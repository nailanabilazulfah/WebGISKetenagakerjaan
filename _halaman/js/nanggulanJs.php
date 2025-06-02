<!-- JS Library -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="assets/js/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
<script src="assets/js/leaflet.ajax.js"></script>
<script src="assets/js/leaflet-bing-layer.js"></script>

<script type="text/javascript">
  var BING_KEY = 'AuhiCJHlGzhg93IqUH_oCpl_-ZUrIE6SPftlyGYUvr9Amx5nzA-WqGcPquyFZl4L';
  var mymap = L.map('maps').setView([-7.780999, 110.204234], 13);

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

  function popUpDusun(f, l) {
    if (f.properties) {
      var html = '<table><tr><td>'+ "Desa: "+ f.properties['Desa'] + '</td></tr></table>';
      html += '<table><tr><td>' + "Dusun: "+ f.properties['Dusun'] + '</td></tr></table>';
      html += '<a href="<?=url('dusun')?>" target="_BLANK">Detail</a>';
      l.bindPopup(html);
    }
  }

  <?php
    $arrayNanggulan = [];
    $getNanggulan = $db->ObjectBuilder()->get('dusun',1);
    $row = $getNanggulan[0];
    foreach ($getNanggulan as $row) {
  ?>
    var myStyle<?=$row->id_dusun?> = {
      "color": "<?=$row->warna_dusun?>",
      "weight": 1,
      "opacity": 1
    };
  <?php
      $arrayNanggulan[] = '{
        name: "'.$row->nama_kecamatan.'",
        icon: iconByName("'.$row->warna_dusun.'"),
        layer: new L.GeoJSON.AJAX(["assets/unggah/dusun_geojson/nanggulan.geojson"], {
          onEachFeature: popUpDusun,
          style: myStyle'.$row->id_dusun.',
          pointToLayer: featureToMarker
        }).addTo(mymap)
      }';
    }
  ?>

  var overLayers = [
    {
      group: "Layer Kecamatan Nanggulan",
      layers: [<?=implode(',', $arrayNanggulan);?>]
    }
  ];

  var panelLayers = new L.Control.PanelLayers(baseLayers);
  mymap.addControl(panelLayers);

  <?php
  $getNanggulan = $db->ObjectBuilder()->get('dusun');
?>

</script>
