<!DOCTYPE html>
<html>

<?php
  $title="Dusun";
  $judul=$title;
  $url='dusun';
  if ($session->get('level')!=='Admin'){
    redirect(url('beranda'));
  }

if(isset($_POST['simpan'])){
  $file=upload('geojson_dusun','geojson');
  if($file!=false){
    $data['geojson_dusun']=$file;
  }

// var_dump($_POST);
  if($_POST['id_dusun']==""){
    $data['nama_kecamatan']=$_POST['nama_kecamatan'];
    $data['warna_dusun']=$_POST['warna_dusun'];
    $db->insert("dusun",$data);
    $info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses Ditambah </div>';
    redirect(url($url));   
   }
  else{
	$data['nama_kecamatan']=$_POST['nama_kecamatan'];
    $data['warna_dusun']=$_POST['warna_dusun'];
	$db->where('id_dusun',$_POST['id_dusun']);
    $db->update('dusun',$data);
    $info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses diubah </div>'; 
    redirect(url($url));
    }
    }

if(isset($_GET['hapus'])){
	$db->where("id_dusun",$_GET['id']);
	$db->delete("dusun");
	$info='<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses dihapus </div>';
  redirect(url($url));
}

if(isset($_GET['tambah']) OR isset($_GET['ubah'])){
  $id_dusun="";
  $nama_kecamatan="";
  $geojson_dusun="";
  $warna_dusun="";
  if(isset($_GET['ubah']) AND isset($_GET['id'])){
	  $id=$_GET['id'];
	  $db->where('id_dusun',$id);  
	  $row=$db->ObjectBuilder()->getOne('dusun');
	  if($db->count>0){
		$id_dusun=$row->id_dusun;
	    $nama_kecamatan=$row->nama_kecamatan;
		$geojson_dusun=$row->geojson_dusun;
        $warna_dusun=$row->warna_dusun;
	}
}

?>

<!-- FORM -->
<?=content_open('Form Dusun')?>
  <form method="post" enctype="multipart/form-data">
    <?=input_hidden('id_dusun',$id_dusun)?>
    <div class="form-group">
      <label>Nama dusun</label>
      <?=input_text('nama_kecamatan',$nama_kecamatan)?>
    </div>
    <div class="form-group">
      <label>GeoJSON</label>
      <?=input_file('geojson_dusun',$geojson_dusun)?>
    </div>
    <div class="form-group">
      <label>Warna dusun</label>
      <?=input_color('warna_dusun',$warna_dusun)?>
    </div>
    <div class="form-group">
      <button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
      <a href="<?=url($url)?>" class= "btn btn-danger"> <i class= "fa fa-reply"></i>Kembali</a>
    </div>
  </form>
<?=content_close()?>

<?php } else {?>
<?=content_open('Data dusun')?>
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
      <th>Nama Dusun</th>
      <th>GeoJSON</th>
      <th>Warna</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no=1;
    // ini ambil dari vendornya joshcam yg berupa array
    $getdata=$db->ObjectBuilder()->get('dusun');
    // foreach utk perulangan array
    foreach ($getdata as $row) {
      ?>
        <tr> 
          <td><?=$no?></td>
          <td><?=$row->nama_kecamatan?></td>
          <td><a href="<?=assets('unggah/dusun_geojson/'.$row->geojson_dusun)?>" target="_BLANK"><?=$row->geojson_dusun?></a></td>
          <td style="background: <?=$row->warna_dusun?>"></td>
           <td>
            <a href="<?=url($url.'&ubah&id='.$row->id_dusun)?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
				    <a href="<?=url($url.'&hapus&id='.$row->id_dusun)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
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