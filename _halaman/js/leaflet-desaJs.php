<!-- JS Library -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="assets/js/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
<script src="assets/js/leaflet.ajax.js"></script>
<script src="assets/js/leaflet-bing-layer.js"></script>

<script type="text/javascript">
    var BING_KEY = 'AuhiCJHlGzhg93IqUH_oCpl_-ZUrIE6SPftlyGYUvr9Amx5nzA-WqGcPquyFZl4L'
    var mymap = L.map('maps').setView([-7.818584, 110.159914], 11);
    
	var LayerKita = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    	maxZoom: 19,
    	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  	}).addTo(mymap);

	var bingLayer = L.tileLayer.bing(BING_KEY);
  	var esriGray = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
    	attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ',
    	maxZoom: 16
 	});

	var baseLayers = [
		{ name: "OpenStreetMap", layer: LayerKita },
		{ name: "Esri Gray", layer: esriGray },
		{ name: "Bing Maps", layer: bingLayer }
  	];

	function iconByName(name) {
    	return '<i class="icon" style="background-color:' + name + ';border-radius:50%"></i>';
  	}

	function featureToMarker(feature, latlng) {
    return L.marker(latlng, {
      icon: L.divIcon({
        className: 'marker-' + feature.properties.amenity,
        html: iconByName(feature.properties.amenity),
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
		})
		});
	}

	function popUpDesa(f, l) {
		if (f.properties) {
		var html = '<table><tr><td>' + f.properties['NAMOBJ'] + '</td></tr></table>';
		html += '<a href="<?=url('desa')?>" target="_BLANK">Detail</a>';
		l.bindPopup(html);
		}
	}
	
	<?php
	$arrayDesa = [];
    $getDesa = $db->ObjectBuilder()->get('desa');
    foreach ($getDesa as $row) {
  	?>
    var myStyle<?=$row->id_desa?> = {
      "color": "<?=$row->warna_desa?>",
      "weight": 1,
      "opacity": 1
    };
  	<?php
      $arrayDesa[] = '{
        name: "'.$row->nama_desa.'",
        icon: iconByName("'.$row->warna_desa.'"),
        layer: new L.GeoJSON.AJAX(["assets/unggah/desa_geojson/'.$row->geojson_desa.'"], {
          onEachFeature: popUpDesa,
          style: myStyle'.$row->id_desa.',
          pointToLayer: featureToMarker
        }).addTo(mymap)
      }';
		}
	?>

	var overLayers = [{
      group: "Layer Desa",
      layers: [<?=implode(',', $arrayDesa);?>]
    }
  ];

	var panelLayers = new L.Control.PanelLayers(baseLayers);
		mymap.addControl(panelLayers);

</script>