<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Brand Logo -->
  <a href="<?= base_url('admin/dashboard'); ?>" class="brand-link">
    <img
      src="<?= base_url('assets/adminlte/dist/img/AdminLTELogo.png'); ?>"
      alt="Zettarig Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: .9"
    >
    <span class="brand-text font-weight-bold">ZETTARIG</span>
  </a>

  <div class="sidebar">

    <!-- Sidebar user panel -->
    <div class="user-panel mt-2 pb-2 mb-2 d-flex">
      <div class="info">
        <a href="#" class="d-block">
          <?= htmlspecialchars($this->session->userdata('admin_nama') ?? 'Admin'); ?>
        </a>
        <small class="text-muted">Administrator</small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false">

        <!-- ================= DASHBOARD ================= -->
        <li class="nav-item">
          <a href="<?= base_url('admin/dashboard'); ?>"
             class="nav-link <?= active_menu('dashboard'); ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- ================= MASTER DATA ================= -->
        <li class="nav-header">MASTER DATA</li>

        <li class="nav-item">
          <a href="<?= base_url('admin/kategori'); ?>"
             class="nav-link <?= active_menu('kategori'); ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>Kategori Produk</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/brand'); ?>"
             class="nav-link <?= active_menu('brand'); ?>">
            <i class="nav-icon fas fa-copyright"></i>
            <p>Brand</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/supplier'); ?>"
             class="nav-link <?= active_menu('supplier'); ?>">
            <i class="nav-icon fas fa-truck"></i>
            <p>Supplier</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/produk'); ?>"
             class="nav-link <?= active_menu('produk'); ?>">
            <i class="nav-icon fas fa-microchip"></i>
            <p>Produk</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/customer'); ?>"
             class="nav-link <?= active_menu('customer'); ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Customer</p>
          </a>
        </li>

        <!-- ================= TRANSAKSI ================= -->
        <li class="nav-header">TRANSAKSI</li>

        <li class="nav-item">
          <a href="<?= base_url('admin/penjualan'); ?>"
             class="nav-link <?= active_menu('penjualan'); ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Penjualan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/pembelian'); ?>"
             class="nav-link <?= active_menu('pembelian'); ?>">
            <i class="nav-icon fas fa-boxes"></i>
            <p>Pembelian Supplier</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/pembayaran'); ?>"
             class="nav-link <?= active_menu('pembayaran'); ?>">
            <i class="nav-icon fas fa-credit-card"></i>
            <p>Pembayaran Transfer</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/cod'); ?>"
             class="nav-link <?= active_menu('cod'); ?>">
            <i class="nav-icon fas fa-money-bill-wave"></i>
            <p>Pembayaran Cash</p>
          </a>
        </li>

        <!-- ================= LAPORAN ================= -->
        <li class="nav-header">LAPORAN</li>

        <li class="nav-item">
          <a href="<?= base_url('admin/laporan'); ?>"
             class="nav-link <?= active_menu('laporan'); ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Laporan</p>
          </a>
        </li>

        <!-- ================= AKUN ================= -->
        <li class="nav-header">AKUN</li>

        <li class="nav-item">
          <a href="<?= base_url('admin/auth/logout'); ?>"
             class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
