<?php
include '_loader.php';
$setTemplate = true;

// Tentukan halaman yang diminta
$halaman = isset($_GET['halaman']) ? $_GET['halaman'] : 'beranda';

// Halaman yang bebas diakses tanpa login
$halamanPublic = ['beranda', 'leaflet-standar', 'leaflet-desa', 'login',
                  'galur', 'girimulyo', 'kalibawang', 'kokap', 'lendah',
                  'nanggulan', 'panjatan', 'pengasih', 'samigaluh',
                  'sentolo', 'temon', 'wates'];

// Akses berdasarkan level (opsional)
$aksesLevel = [
  'admin' => ['beranda', 'kecamatan']
];

// Cek apakah pengguna sudah login
$logged = $session->get("logged") === true;
$level  = $session->get("level");

// Jika belum login & halaman bukan publik → redirect ke login
if (!$logged && !in_array($halaman, $halamanPublic)) {
  redirect(url('login'));
}

// Jika sudah login, batasi akses berdasarkan level
if ($logged && isset($aksesLevel[$level])) {
  $halamanTerbatas = array_merge(...array_values($aksesLevel));
  if (in_array($halaman, $halamanTerbatas) && !in_array($halaman, $aksesLevel[$level])) {
    // Jika halaman termasuk yang dibatasi dan bukan hak akses level ini
    $session->set("info", "<div class='alert alert-danger'>Anda tidak memiliki akses ke halaman ini.</div>");
    redirect(url('beranda'));
  }
}

// Load halaman
ob_start();
$file = '_halaman/' . $halaman . '.php';
if (!file_exists($file)) {
  include '_halaman/error.php';
} else {
  include $file;
}
$content = ob_get_clean();

// Template view
if ($setTemplate == true) {
?>

<!DOCTYPE html>
<html lang="en">
<?php include '_layouts/head.php'?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    
<?php
    include '_layouts/header.php';
    include '_layouts/sidebar.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
              <?=$judul?>
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?=$judul?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<?php
  //harusnya di sini echo $halaman;
  echo $content;
  include '_layouts/footer.php';
  // include '_layouts/body.php';
?>
  <!-- /.content -->
  </div>
    <!-- /.content-wrapper -->
<?php
  include '_layouts/javascript.php';
?>
</div>  
</body>
</html>

<?php } else {
  echo $content;
}
if(isset($fileJs)){
  include '_halaman/js/'.$fileJs.'.php';
}
?>


