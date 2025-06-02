<?php
  $title="Beranda";
  $judul=$title;
?>

<?php
// data jumlah pencari kerja per kecamatan dari database
$jumlahPerKecamatan = $db->rawQuery("SELECT nama_kecamatan, COUNT(*) AS jumlah FROM pencari_kerja GROUP BY nama_kecamatan");

// label dan data untuk chart
$labels = [];
$data = [];

foreach ($jumlahPerKecamatan as $row) {
    $labels[] = $row['nama_kecamatan'];
    $data[] = $row['jumlah'];
}
?>

<!-- Container Utama -->
<div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
  <!-- Judul -->
  <h3 style="text-align: center;">Grafik Jumlah Pencari Kerja per Kecamatan
    <br>
    pada Bulan Januari, Februari, dan Maret Tahun 2025
  </h3>
  <!-- Grafik -->
  <div style="width: 800px; height: 400px;">
    <canvas id="grafikKecamatan"></canvas>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('grafikKecamatan').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($labels) ?>,
      datasets: [{
        label: 'Jumlah Pencari Kerja',
        data: <?= json_encode($data) ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Jumlah'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Kecamatan'
          }
        }
      },
      plugins: {
        title: {
          display: false // Judul ditampilkan di luar canvas
        },
        legend: {
          display: false
        }
      }
    }
  });
</script>

<?=content_open('Halaman Beranda')?>
    
    <h1 style="font-size:20px;"><b>Deskripsi Singkat</b></h1>
    <p style="text-align:justify; font-size:15px;">
    <br>
      WebGIS ini bertujuan untuk membantu Dinas Tenaga Kerja Kabupaten Kulon Progo dalam pendataan ketenagakerjaan
      di Kabupaten Kulon Progo. Website ini dibangun untuk memenuhi persyaratan tugas akhir di Program Studi
      Sarjana Teknik Geodesi Universitas Gadjah Mada.
    </p>

    <br>
    <b>Sumber data:</b>
    <br>
    Data pencari kerja diperoleh dari Dinas Tenaga Kerja Kabupaten Kulon Progo
    <br>
    <br>
    <p style="text-align:right; font-size:15px;">
    <b>Peneliti</b>
    <br>
    <br>
    Naila Nabila Zulfah
    <br>
    contact : nnabilaz.nd@gmail.com
    </p>

<?=content_close()?>