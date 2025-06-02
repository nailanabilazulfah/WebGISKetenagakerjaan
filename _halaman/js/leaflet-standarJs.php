<!-- JS Library -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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

	function popUpKecamatan(f, l) {
	if (f.properties && f.properties['nm_kec']) {
		var namaKec = f.properties['nm_kec'].toLowerCase();
		var html = '<table><tr><td>' + f.properties['nm_kec'] + '</td></tr></table>';
		html += '<a href="<?=url()?>' + namaKec + '" target="_BLANK">Detail</a>';
		l.bindPopup(html);
	}
	}

	<?php
    $arrayKec = [];
    $getKecamatan = $db->ObjectBuilder()->get('kecamatan');
    foreach ($getKecamatan as $row) {
  ?>
    var myStyle<?=$row->id_kecamatan?> = {
      "color": "<?=$row->warna_kecamatan?>",
      "weight": 1,
      "opacity": 1
    };
  <?php
      $arrayKec[] = '{
        name: "'.$row->nama_kecamatan.'",
        icon: iconByName("'.$row->warna_kecamatan.'"),
        layer: new L.GeoJSON.AJAX(["assets/unggah/geojson/'.$row->geojson_kecamatan.'"], {
          onEachFeature: popUpKecamatan,
          style: myStyle'.$row->id_kecamatan.',
          pointToLayer: featureToMarker
        }).addTo(mymap)
      }';
    }
	?>

    var overLayers = [{
		group: "Layer Kecamatan",
		layers: [
			<?=implode(',', $arrayKec);?>
		]
	}
	];

	var panelLayers = new L.Control.PanelLayers(baseLayers);
	mymap.addControl(panelLayers);
	<?php
  	$getKecamatan = $db->ObjectBuilder()->get('kecamatan');
	?>

	// LEGEND KECAMATAN
		var legendKecamatan = L.control({ position: 'bottomleft' });
		legendKecamatan.onAdd = function (map) {
		var div = L.DomUtil.create('div', 'legend');
		div.innerHTML += '<div class="legend-title">Legenda Kecamatan</div>';
	// Buat container grid
	var grid = '<div class="legend-grid">';
	<?php 
	$count = 0;
	foreach ($getKecamatan as $row): 
		// Escape warna dan nama
		$warna = $row->warna_kecamatan;
		$nama = $row->nama_kecamatan;
	?>
		grid += '<div class="legend-item"><i style="background:<?=$warna?>"></i> <?=$nama?></div>';
	<?php endforeach; ?>
	grid += '</div>';
	div.innerHTML += grid;
	return div;
	};
	legendKecamatan.addTo(mymap);


</script>