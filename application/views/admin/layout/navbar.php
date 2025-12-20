<div class="preloader flex-column justify-content-center align-items-center">
  <img 
    class="animation__wobble" 
    src="<?= base_url('assets/adminlte/dist/img/AdminLTELogo.png'); ?>" 
    alt="Zettarig Logo" 
    height="150" 
    width="150"
  >
</div>

<nav class="main-header navbar navbar-expand navbar-dark">

  <ul class="navbar-nav">
    
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>

    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('admin/dashboard'); ?>" class="nav-link">
        Dashboard
      </a>
    </li>

  </ul>

  <ul class="navbar-nav ml-auto">

    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      
      <div class="navbar-search-block">
        <form class="form-inline" action="<?= base_url('admin/search'); ?>" method="get">
          <div class="input-group input-group-sm">
            <input 
              class="form-control form-control-navbar" 
              type="search" 
              name="q" 
              placeholder="Cari Produk, Customer, Transaksi..." 
              aria-label="Search"
              value="<?= $this->input->get('q'); ?>"
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
        
        <span class="dropdown-item dropdown-header font-weight-bold">
          <?= $notif_count ?? 0; ?> Notifikasi Baru
        </span>
        
        <div class="dropdown-divider"></div>

        <?php if (!empty($notif_items)): ?>
          <?php foreach ($notif_items as $n): ?>
            
            <a href="<?= base_url('admin/penjualan/detail/'.$n->id_penjualan); ?>" class="dropdown-item">
              
              <div class="media align-items-center">
                  
                  <div class="mr-3 text-center" style="width: 30px;">
                      <?php if ($n->status_pesanan == 'dibuat'): ?>
                          <i class="fas fa-shopping-cart fa-lg text-primary"></i>
                      <?php else: ?>
                          <i class="fas fa-file-invoice-dollar fa-lg text-warning"></i>
                      <?php endif; ?>
                  </div>

                  <div class="media-body">
                      
                      <h3 class="dropdown-item-title font-weight-bold" style="font-size: 1rem;">
                          <?php if ($n->status_pesanan == 'dibuat'): ?>
                              <span class="text-primary">Pesanan Baru</span>
                          <?php else: ?>
                              <span class="text-warning">Cek Bukti Transfer</span>
                          <?php endif; ?>
                      </h3>
                      
                      <p class="text-sm text-muted mb-0">
                          <?= substr($n->nama_customer, 0, 15) . (strlen($n->nama_customer) > 15 ? '...' : ''); ?>
                      </p>

                      <p class="text-xs text-muted mb-0">
                          <i class="far fa-clock mr-1"></i> <?= date('H:i', strtotime($n->tanggal_pesanan)); ?> 
                          &bull; 
                          <strong>Rp <?= number_format($n->total_harga, 0,',','.'); ?></strong>
                      </p>
                  </div>
              </div>

            </a>
            <div class="dropdown-divider"></div>

          <?php endforeach; ?>
        <?php else: ?>
          <span class="dropdown-item text-center text-muted py-3">
            <i class="far fa-check-circle mb-2"></i><br>
            Tidak ada notifikasi baru
          </span>
        <?php endif; ?>

        <div class="dropdown-divider"></div>
        <a href="<?= base_url('admin/penjualan'); ?>" class="dropdown-item dropdown-footer text-center bg-light">
          <strong>Lihat Semua Pesanan</strong> <i class="fas fa-arrow-circle-right ml-1"></i>
        </a>

      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>

  </ul>
</nav>