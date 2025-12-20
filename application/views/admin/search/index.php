<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Hasil Pencarian Global</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item text-muted">Keyword: "<strong><?= $keyword; ?></strong>"</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="row">
      
      <div class="col-md-4">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-box mr-1"></i> Produk (<?= count($hasil_produk); ?>)
            </h3>
          </div>
          
          <div class="card-body p-0">
            <?php if(!empty($hasil_produk)): ?>
              <ul class="products-list product-list-in-card pl-2 pr-2">
                
                <?php foreach($hasil_produk as $p): ?>
                <li class="item">
                  <div class="product-img">
                    <div class="d-flex justify-content-center align-items-center bg-light text-secondary" style="width: 50px; height: 50px; border-radius: 5px;">
                        <i class="fas fa-cube fa-lg"></i>
                    </div>
                  </div>
                  <div class="product-info">
                    <a href="<?= base_url('admin/produk/edit/'.$p->id_produk); ?>" class="product-title">
                        <?= $p->nama_produk; ?>
                        
                        <?php 
                            $badge_color = 'badge-success';
                            if($p->stok == 0) $badge_color = 'badge-danger';
                            elseif($p->stok < 5) $badge_color = 'badge-warning';
                        ?>
                        <span class="badge <?= $badge_color; ?> float-right">Stok: <?= $p->stok; ?></span>
                    </a>
                    <span class="product-description">
                      <span class="text-dark font-weight-bold">Rp <?= number_format($p->harga ?? 0, 0, ',', '.'); ?></span>
                      &bull; 
                      <a href="<?= base_url('admin/produk/edit/'.$p->id_produk); ?>" class="text-sm">Edit</a>
                    </span>
                  </div>
                </li>
                <?php endforeach; ?>

              </ul>
            <?php else: ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-box-open fa-3x mb-2"></i><br>
                    Produk tidak ditemukan.
                </div>
            <?php endif; ?>
          </div>
          
          <?php if(!empty($hasil_produk)): ?>
          <div class="card-footer text-center">
            <a href="<?= base_url('admin/produk'); ?>" class="uppercase">Lihat Semua Produk</a>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-success card-outline">
          <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users mr-1"></i> Customer (<?= count($hasil_customer); ?>)
            </h3>
          </div>
          
          <div class="card-body p-0">
            <?php if(!empty($hasil_customer)): ?>
              <div class="list-group list-group-flush">
                  
                <?php foreach($hasil_customer as $c): ?>
                <div class="list-group-item d-flex align-items-center p-3">
                    
                    <div class="flex-shrink-0 mr-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle font-weight-bold text-white shadow-sm" 
                             style="width: 45px; height: 45px; font-size: 18px; background-color: #28a745;">
                            <?= strtoupper(substr($c->nama, 0, 1)); ?>
                        </div>
                    </div>
                    
                    <div class="flex-grow-1" style="min-width: 0;">
                        <h6 class="mb-0 font-weight-bold text-dark text-truncate">
                            <?= $c->nama; ?>
                            
                            <?php if($c->status_aktif): ?>
                                <small><i class="fas fa-circle text-success ml-1" style="font-size: 8px;" title="Aktif"></i></small>
                            <?php else: ?>
                                <small><i class="fas fa-circle text-secondary ml-1" style="font-size: 8px;" title="Nonaktif"></i></small>
                            <?php endif; ?>
                        </h6>
                        
                        <div class="text-muted text-sm text-truncate">
                            <i class="fas fa-envelope mr-1 text-xs"></i> <?= $c->email; ?>
                        </div>
                        <div class="text-muted text-sm">
                            <i class="fas fa-phone mr-1 text-xs"></i> <?= $c->no_hp ? $c->no_hp : '-'; ?>
                        </div>
                    </div>

                    <div class="ml-2">
                        <a href="<?= base_url('admin/customer/edit/'.$c->id_customer); ?>" 
                           class="btn btn-sm btn-outline-success" 
                           title="Edit Customer">
                            <i class="fas fa-pen"></i>
                        </a>
                    </div>
                    
                </div>
                <?php endforeach; ?>

              </div>
            <?php else: ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-user-slash fa-3x mb-2 text-gray-300"></i><br>
                    Customer tidak ditemukan.
                </div>
            <?php endif; ?>
          </div>
          
          <?php if(!empty($hasil_customer)): ?>
          <div class="card-footer text-center">
            <a href="<?= base_url('admin/customer'); ?>" class="text-success font-weight-bold">Lihat Semua Customer</a>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-warning card-outline">
          <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-shopping-cart mr-1"></i> Transaksi (<?= count($hasil_penjualan); ?>)
            </h3>
          </div>
          
          <div class="card-body p-0">
             <?php if(!empty($hasil_penjualan)): ?>
                <div class="list-group list-group-flush">
                    <?php foreach($hasil_penjualan as $t): ?>
                    
                    <a href="<?= base_url('admin/penjualan/detail/'.$t->id_penjualan); ?>" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h6 class="mb-0 font-weight-bold text-dark">
                                #<?= $t->id_penjualan; ?>
                            </h6>
                            <small class="text-muted">
                                <?= date('d M Y', strtotime($t->tanggal_pesanan)); ?>
                            </small>
                        </div>
                        
                        <p class="mb-1 text-sm">
                            Customer: <strong><?= $t->nama_customer; ?></strong>
                        </p>
                        
                        <div class="d-flex w-100 justify-content-between align-items-center mt-2">
                             <span class="text-primary font-weight-bold">
                                 Rp <?= number_format($t->total_harga, 0, ',', '.'); ?>
                             </span>
                             
                             <?php
                                $status_class = 'badge-secondary';
                                switch($t->status_pesanan){
                                    case 'dibuat': 
                                    case 'menunggu_pembayaran': $status_class = 'badge-warning'; break;
                                    case 'menunggu_verifikasi': $status_class = 'badge-info'; break;
                                    case 'diproses': $status_class = 'badge-primary'; break;
                                    case 'dikirim': $status_class = 'bg-purple'; break;
                                    case 'selesai': $status_class = 'badge-success'; break;
                                    case 'dibatalkan': $status_class = 'badge-danger'; break;
                                }
                             ?>
                             <span class="badge <?= $status_class; ?>">
                                 <?= ucfirst($t->status_pesanan); ?>
                             </span>
                        </div>
                    </a>

                    <?php endforeach; ?>
                </div>
             <?php else: ?>
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-receipt fa-3x mb-2"></i><br>
                    Transaksi tidak ditemukan.
                </div>
             <?php endif; ?>
          </div>
          
          <?php if(!empty($hasil_penjualan)): ?>
          <div class="card-footer text-center">
            <a href="<?= base_url('admin/penjualan'); ?>" class="uppercase">Lihat Semua Transaksi</a>
          </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>