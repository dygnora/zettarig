<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detail Laporan Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/laporan'); ?>">Laporan</a>
          </li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card card-outline card-primary mb-3">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-user mr-1"></i> Informasi Customer
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>Nama Lengkap:</strong><br>
                <span class="text-lg"><?= htmlspecialchars($customer->nama); ?></span>
            </div>
            </div>
      </div>
    </div>

    <div class="mb-3">
        <a href="<?= base_url('admin/laporan/export_pdf_user/'.$customer->id_customer.'?mode='.$mode.'&start='.$start.'&end='.$end); ?>" 
           class="btn btn-danger btn-sm mr-1">
           <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        
        <a href="<?= base_url('admin/laporan/export_excel_user/'.$customer->id_customer.'?mode='.$mode.'&start='.$start.'&end='.$end); ?>" 
           class="btn btn-success btn-sm">
           <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>

    <div class="card card-dark">
      
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-shopping-cart mr-1"></i> Riwayat Transaksi
        </h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th width="50">No</th>
              <th>Tanggal</th>
              <th>Produk</th>
              <th width="80" class="text-center">Qty</th>
              <th width="100" class="text-center">Metode</th>
              <th width="120" class="text-center">Status</th>
              <th width="150" class="text-right">Subtotal</th>
            </tr>
          </thead>
          
          <tbody>
            <?php 
              $no = 1; 
              $grand_total = 0; 
            ?>

            <?php if (!empty($detail)) : ?>
              <?php foreach ($detail as $d): ?>
                <?php $grand_total += $d->subtotal; ?>
                <tr>
                  <td><?= $no++; ?></td>
                  
                  <td>
                    <?= date('d-m-Y', strtotime($d->tanggal_pesanan)); ?>
                  </td>
                  
                  <td>
                    <strong><?= htmlspecialchars($d->nama_produk); ?></strong>
                  </td>
                  
                  <td class="text-center">
                    <?= $d->jumlah; ?>
                  </td>
                  
                  <td class="text-center">
                    <span class="badge badge-light border">
                        <?= strtoupper($d->metode_pembayaran); ?>
                    </span>
                  </td>
                  
                  <td class="text-center">
                    <?php 
                        $st = strtolower($d->status_pesanan);
                        if(in_array($st, ['selesai','lunas'])) {
                            echo '<span class="badge badge-success">'.ucfirst($st).'</span>';
                        } elseif(in_array($st, ['dibatalkan','ditolak'])) {
                            echo '<span class="badge badge-danger">'.ucfirst($st).'</span>';
                        } else {
                            echo '<span class="badge badge-warning">'.ucfirst($st).'</span>';
                        }
                    ?>
                  </td>
                  
                  <td class="text-right">
                    Rp <?= number_format($d->subtotal, 0, ',', '.'); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-3">
                  <i class="fas fa-inbox mb-2"></i><br>
                  Tidak ada transaksi pada periode ini
                </td>
              </tr>
            <?php endif; ?>
          </tbody>

          <?php if (!empty($detail)) : ?>
          <tfoot>
            <tr class="bg-light">
              <th colspan="6" class="text-right font-weight-bold">
                TOTAL KESELURUHAN :
              </th>
              <th class="text-right font-weight-bold">
                Rp <?= number_format($grand_total, 0, ',', '.'); ?>
              </th>
            </tr>
          </tfoot>
          <?php endif; ?>

        </table>
      </div>

      <div class="card-footer">
        <a href="<?= base_url('admin/laporan?mode='.$mode.'&start='.$start.'&end='.$end); ?>" 
           class="btn btn-secondary btn-sm">
           <i class="fas fa-arrow-left"></i> Kembali ke Laporan Utama
        </a>
      </div>

    </div>

  </div>
</section>