
<?php
  $title="Peta Kecamatan Ketenagakerjaan Kulon Progo";
  $judul=$title;
  $url='leaflet-standar';
  $fileJs='leaflet-standarJs';
?>

<?=content_open($title)?>
  <div id="maps"></div>
  <style>
.legend {
  background: white;
  padding: 10px;
  color: #333;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  font-size: 14px;
  max-height: 300px;
  overflow-y: auto;
}
.legend-title {
  font-weight: bold;
  margin-bottom: 8px;
}
/* grid 4 kolom */
.legend-grid {
  display: grid;
  grid-template-columns: repeat(4, auto);
  gap: 8px 20px;
}
/* Item legend dengan icon dan text */
.legend-item {
  display: flex;
  align-items: center;
  gap: 6px;
}
.legend-item i {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  opacity: 0.8;
  flex-shrink: 0;
}
</style>
<?=content_close()?>

