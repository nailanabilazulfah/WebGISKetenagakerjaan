<!DOCTYPE html>
<html>

<?php
  $title="Kecamatan";
  $judul=$title;
  $url='kecamatan';
  if ($session->get('level')!=='Admin'){
    redirect(url('beranda'));
  }

if(isset($_POST['simpan'])){
  $file=upload('geojson_kecamatan','geojson');
  if($file!=false){
    $data['geojson_kecamatan']=$file;
  }

// var_dump($_POST);
  if($_POST['id_kecamatan']==""){
    $data['kode_kecamatan']=$_POST['kode_kecamatan'];
    $data['nama_kecamatan']=$_POST['nama_kecamatan'];
    $data['warna_kecamatan']=$_POST['warna_kecamatan'];
    $db->insert("kecamatan",$data);
    $info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses Ditambah </div>';
    redirect(url($url));   
   }
  else{
    $data['kode_kecamatan']=$_POST['kode_kecamatan'];
		$data['nama_kecamatan']=$_POST['nama_kecamatan'];
    $data['warna_kecamatan']=$_POST['warna_kecamatan'];
		$db->where('id_kecamatan',$_POST['id_kecamatan']);
		$db->update('kecamatan',$data);
    $info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses diubah </div>'; 
    redirect(url($url));
    }
    }

if(isset($_GET['hapus'])){
	$db->where("id_kecamatan",$_GET['id']);
	$db->delete("kecamatan");
	$info='<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses dihapus </div>';
  redirect(url($url));
}

if(isset($_GET['tambah']) OR isset($_GET['ubah'])){
  $id_kecamatan="";
  $kode_kecamatan="";
  $nama_kecamatan="";
  $geojson_kecamatan="";
  $warna_kecamatan="";
  if(isset($_GET['ubah']) AND isset($_GET['id'])){
	  $id=$_GET['id'];
	  $db->where('id_kecamatan',$id);  
	  $row=$db->ObjectBuilder()->getOne('kecamatan');
	  if($db->count>0){
		  $id_kecamatan=$row->id_kecamatan;
		  $kode_kecamatan=$row->kode_kecamatan;
		  $nama_kecamatan=$row->nama_kecamatan;
		  $geojson_kecamatan=$row->geojson_kecamatan;
      $warna_kecamatan=$row->warna_kecamatan;
	}
}

?>

<!-- FORM -->
<?=content_open('Form Kecamatan')?>
  <form method="post" enctype="multipart/form-data">
    <?=input_hidden('id_kecamatan',$id_kecamatan)?>
    <div class="form-group">
      <label>Kode Kecamatan</label>
      <?=input_text('kode_kecamatan',$kode_kecamatan)?>
    </div>
    <div class="form-group">
      <label>Nama Kecamatan</label>
      <?=input_text('nama_kecamatan',$nama_kecamatan)?>
    </div>
    <div class="form-group">
      <label>GeoJSON</label>
      <?=input_file('geojson_kecamatan',$geojson_kecamatan)?>
    </div>
    <div class="form-group">
      <label>Warna Kecamatan</label>
      <?=input_color('warna_kecamatan',$warna_kecamatan)?>
    </div>
    <div class="form-group">
      <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
      <a href="<?=url($url)?>" class= "btn btn-danger"> <i class= "fa fa-reply"></i>Kembali</a>
    </div>
  </form>
<?=content_close()?>

<?php } else {?>
<?=content_open('Data Kecamatan')?>
<!-- Ketika ada tambah, maka form tidak tampil -->
<a href="<?=url($url.'&tambah')?>" class= "btn btn-success"> <i class= "fa fa-plus"></i>Tambah</a>
<hr>

<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="//cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet" />
<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
<script src="//cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" defer></script>
<script src="//cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" defer></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" defer></script>
<script src="//cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" defer></script>

<table id="example" class="display">
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Kecamatan</th>
      <th>Nama Kecamatan</th>
      <th>GeoJSON</th>
      <th>Warna</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no=1;
    // ini ambil dari vendornya joshcam yg berupa array
    $getdata=$db->ObjectBuilder()->get('kecamatan');
    // foreach utk perulangan array
    foreach ($getdata as $row) {
      ?>
        <tr> 
          <td><?=$no?></td>
          <td><?=$row->kode_kecamatan?></td>
          <td><?=$row->nama_kecamatan?></td>
          <td><a href="<?=assets('unggah/geojson/'.$row->geojson_kecamatan)?>" target="_BLANK"><?=$row->geojson_kecamatan?></a></td>
          <td style="background: <?=$row->warna_kecamatan?>"></td>
           <td>
            <a href="<?=url($url.'&ubah&id='.$row->id_kecamatan)?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
				    <a href="<?=url($url.'&hapus&id='.$row->id_kecamatan)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
           </td>
        </tr>
      <?php
      // setiap kali perulangan nambah 1
      $no++; 
    }
    
    ?>
  </tbody>
</table> 

<script>
$(document).ready( function () {
    $('table#example').DataTable({
		dom: 'Bfrtip',
		"paging": true,
		"order": [[ 0, "asc" ]],
		"ordering": true,
		"columnDefs": [{
			"targets": [3], /* column index */
			"orderable": false
		},
		{
			"targets": [ 1 ],
			"visible": true,
			"searchable": true
		}],
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	});
});
</script>

<?=content_close()?>
<?php } ?>

</html>