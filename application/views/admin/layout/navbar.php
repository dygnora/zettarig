<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
  <img
    class="animation__wobble"
    src="<?= base_url('assets/adminlte/dist/img/AdminLTELogo.png'); ?>"
    alt="Zettarig Logo"
    height="150"
    width="150"
  >
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">

  <!-- LEFT NAVBAR -->
  <ul class="navbar-nav">

    <!-- Toggle Sidebar -->
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>

    <!-- Dashboard -->
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('admin/dashboard'); ?>" class="nav-link">
        Dashboard
      </a>
    </li>

  </ul>

  <!-- RIGHT NAVBAR -->
  <ul class="navbar-nav ml-auto">

    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>

      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input
              class="form-control form-control-navbar"
              type="search"
              placeholder="Search"
              aria-label="Search"
            >
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button
                class="btn btn-navbar"
                type="button"
                data-widget="navbar-search"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- ================= NOTIFICATIONS ================= -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>

        <?php if (!empty($notif_count) && $notif_count > 0): ?>
          <span class="badge badge-warning navbar-badge">
            <?= $notif_count; ?>
          </span>
        <?php endif; ?>
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        <span class="dropdown-item dropdown-header">
          <?= $notif_count ?? 0; ?> Pesanan Baru
        </span>

        <div class="dropdown-divider"></div>

        <?php if (!empty($notif_items)): ?>
          <?php foreach ($notif_items as $n): ?>
            <a href="<?= base_url('admin/penjualan/detail/'.$n->id_penjualan); ?>"
               class="dropdown-item">

              <i class="fas fa-shopping-cart mr-2"></i>
              <?= htmlspecialchars($n->nama_customer); ?>

              <span class="float-right text-muted text-sm">
                <?= date('H:i', strtotime($n->tanggal_pesanan)); ?>
              </span>

              <br>
              <small class="text-muted">
                Rp <?= number_format($n->total_harga, 0, ',', '.'); ?>
              </small>
            </a>

            <div class="dropdown-divider"></div>
          <?php endforeach; ?>
        <?php else: ?>
          <span class="dropdown-item text-center text-muted">
            Tidak ada pesanan baru
          </span>
        <?php endif; ?>

        <a href="<?= base_url('admin/penjualan'); ?>"
           class="dropdown-item dropdown-footer">
          Lihat semua pesanan
        </a>

      </div>
    </li>
    <!-- =============== END NOTIFICATIONS =============== -->

    <!-- Fullscreen -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- Control Sidebar -->
    <li class="nav-item">
      <a
        class="nav-link"
        data-widget="control-sidebar"
        data-slide="true"
        href="#"
        role="button"
      >
        <i class="fas fa-th-large"></i>
      </a>
    </li>

  </ul>
</nav>
<!-- /.navbar -->
