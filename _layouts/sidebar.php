<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?=url('beranda')?>" class="brand-link">
    <span class="brand-text font-weight-light"><b>WebGIS Ketenagakerjaan</b></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Beranda -->
        <li class="nav-item">
          <a href="<?=url('beranda')?>" class="nav-link">
            <i class="nav-icon fa fa-home"></i>
            <p>Beranda</p>
          </a>
        </li>

        <!-- Peta -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-map"></i>
            <p>
              Peta
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=url('leaflet-standar')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kecamatan</p>
              </a>
            </li>
            <?php if ($session->get('level') == 'Admin'): ?>
            <li class="nav-item">
              <a href="<?=url('leaflet-desa')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Desa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('leaflet-control')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Coba</p>
              </a>
            </li>
            <?php endif ?>
          </ul>
        </li>

        <!-- Peta Desa per Kecamatan untuk Admin -->
        <?php if ($session->get('level') == 'Admin'): ?>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-map-marker"></i>
            <p>
              Peta Per Kecamatan
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=url('galur')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Galur</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('girimulyo')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Girimulyo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('kalibawang')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kalibawang</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('kokap')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kokap</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('lendah')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Lendah</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('nanggulan')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Nanggulan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('panjatan')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Panjatan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('pengasih')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pengasih</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('samigaluh')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Samigaluh</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('sentolo')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sentolo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('temon')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Temon</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('wates')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Wates</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif ?>


        <!-- Tabel (Admin) -->
        <?php if ($session->get('level') == 'Admin'): ?>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Tabel
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?=url('kecamatan')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kecamatan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('desa')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Desa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?=url('dusun')?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dusun</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif ?>

        <!-- Login -->
        <?php if (empty($session->get('level'))): ?>
        <li class="nav-item">
          <a href="<?=url('login')?>" class="nav-link">
            <i class="nav-icon fas fa-sign-in-alt"></i>
            <p>Log in</p>
          </a>
        </li>
        <?php endif ?>

        <!-- Logout -->
        <?php if ($session->get('level') == 'Admin'): ?>
        <li class="nav-item">
          <a href="<?=url('logout')?>" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Log out</p>
          </a>
        </li>
        <?php endif ?>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
