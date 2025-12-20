<?php
/**
 * ==========================================================
 * DETAIL PESANAN CUSTOMER - ZETTARIG
 * ==========================================================
 */
?>

<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-2">DETAIL PESANAN</h1>
    <p class="text-muted mb-0">
      Pesanan #<?= $pesanan->id_penjualan; ?>
    </p>
  </div>
</section>

<section class="container py-5">

  <div class="row">
    <div class="col-md-8">
        
      <div class="card bg-dark text-light pixel-card p-4 mb-4">
        <p class="mb-1"><strong>Tanggal</strong></p>
        <p class="text-muted">
          <?= date('d M Y H:i', strtotime($pesanan->tanggal_pesanan)); ?>
        </p>

        <p class="mb-1"><strong>Status Pesanan</strong></p>
        <p>
          <?php
          switch ($pesanan->status_pesanan) {
            case 'dibuat':
            case 'menunggu_pembayaran':
              echo '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>';
              break;
            case 'menunggu_verifikasi':
              echo '<span class="badge bg-info text-dark">Menunggu Verifikasi Admin</span>';
              break;
            case 'diproses':
              echo '<span class="badge bg-primary">Diproses</span>';
              break;
            case 'dikirim':
              echo '<span class="badge bg-secondary">Dikirim</span>';
              break;
            case 'selesai':
              echo '<span class="badge bg-success">Selesai</span>';
              break;
            case 'dibatalkan':
              echo '<span class="badge bg-danger">Dibatalkan</span>';
              break;
            default:
              echo '<span class="badge bg-secondary">'.$pesanan->status_pesanan.'</span>';
          }
          ?>
        </p>
      </div>

      <div class="card bg-dark text-light pixel-card p-4 mb-4">
        <h5 class="mb-3">Produk</h5>
        <div class="table-responsive">
          <table class="table table-dark table-bordered align-middle">
            <thead class="text-center">
              <tr>
                <th>Produk</th>
                <th width="80">Qty</th>
                <th width="160">Harga</th>
                <th width="160">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($detail as $item): ?>
                <tr>
                  <td>
                      <div class="d-flex align-items-center">
                          <?php if(!empty($item->gambar_produk)): ?>
                              <img src="<?= base_url('uploads/produk/'.$item->gambar_produk); ?>" 
                                   style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px; border: 1px solid #444;">
                          <?php endif; ?>
                          <?= htmlspecialchars($item->nama_produk); ?>
                      </div>
                  </td>
                  <td class="text-center"><?= $item->jumlah; ?></td>
                  <td class="text-end">
                    Rp <?= number_format($item->harga_satuan, 0, ',', '.'); ?>
                  </td>
                  <td class="text-end">
                    Rp <?= number_format($item->subtotal, 0, ',', '.'); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between mt-3">
          <strong>Total Belanja</strong>
          <strong>
            Rp <?= number_format($pesanan->total_harga, 0, ',', '.'); ?>
          </strong>
        </div>
      </div>
    </div>

    <div class="col-md-4">
        
      <div class="card bg-dark text-light pixel-card p-4">
        <h5 class="mb-3">Pembayaran</h5>
        
        <?php 
            $last_timeline = !empty($timeline) ? end($timeline) : null;
            if ($last_timeline && strpos(strtolower($last_timeline->status_tahap), 'ditolak') !== false): 
        ?>
            <div class="alert alert-danger mb-3" style="border: 2px solid #ff4444; background: rgba(255,0,0,0.2); color: #ffadad;">
                <i class="fas fa-exclamation-circle"></i> <strong>Pembayaran Ditolak!</strong><br>
                <small>Alasan: <?= $last_timeline->catatan; ?></small>
            </div>
        <?php endif; ?>


        <?php if ($pesanan->metode_pembayaran === 'transfer'): ?>

            <?php if (in_array($pesanan->status_pesanan, ['dibuat', 'menunggu_pembayaran'])): ?>
              <div class="alert alert-warning text-dark mb-3">
                <small>Silakan transfer ke rekening:<br>
                <strong>BCA 1234567890</strong> a.n Zettarig<br>
                Lalu upload bukti transfer di bawah ini.</small>
              </div>

              <a href="<?= base_url('pembayaran/upload/'.$pesanan->id_penjualan); ?>"
                 class="btn btn-warning w-100 mb-3 pixel-btn">
                 UPLOAD BUKTI FULL
              </a>
            <?php endif; ?>

            <?php if ($pesanan->status_pesanan === 'menunggu_verifikasi'): ?>
              <div class="alert alert-info text-dark">
                <i class="fas fa-clock"></i> Bukti transfer sudah dikirim.<br>
                Silakan menunggu verifikasi dari admin.
              </div>
            <?php endif; ?>

        <?php elseif ($pesanan->metode_pembayaran === 'cod'): ?>
            
            <div class="mb-3 border-bottom border-secondary pb-3">
                <p class="mb-1 text-muted small">Metode Bayar:</p>
                <strong>Cash On Delivery (COD)</strong>
            </div>

            <?php if (isset($cod) && $cod->dp_wajib > 0): ?>
                
                <div class="alert alert-dark border border-warning text-warning mb-3">
                    <small>
                        <i class="fas fa-exclamation-triangle"></i>
                        Pesanan > 5 Juta wajib DP 20%.
                    </small>
                </div>

                <ul class="list-group list-group-flush bg-transparent mb-3 text-small">
                    <li class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-1">
                        <span>Wajib DP (20%)</span>
                        <span class="text-warning">Rp <?= number_format($cod->dp_wajib, 0, ',', '.'); ?></span>
                    </li>
                    <li class="list-group-item bg-transparent text-light d-flex justify-content-between px-0 py-1">
                        <span>Sisa (Bayar Kurir)</span>
                        <span>Rp <?= number_format($cod->sisa_pembayaran, 0, ',', '.'); ?></span>
                    </li>
                </ul>

                <?php if ($cod->status_dp === 'diterima'): ?>
                    
                    <div class="alert alert-success text-dark">
                        <i class="fas fa-check-circle"></i> DP Lunas. Pesanan Diproses.
                    </div>

                <?php elseif ($cod->status_dp === 'menunggu' && !empty($cod->bukti_dp)): ?>
                    
                    <div class="alert alert-info text-dark">
                        <i class="fas fa-spinner fa-spin"></i> Bukti DP sedang diverifikasi.
                    </div>

                <?php else: ?>
                    <div class="card p-3 bg-secondary mb-3">
                        <small class="mb-2 d-block">Upload Bukti DP Disini:</small>
                        
                        <form action="<?= base_url('pembayaran/process_dp'); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_penjualan" value="<?= $pesanan->id_penjualan; ?>">
                            
                            <input type="file" name="bukti_dp" class="form-control form-control-sm mb-2" required>
                            
                            <button type="submit" class="btn btn-warning btn-sm w-100 pixel-btn">
                                KIRIM BUKTI DP
                            </button>
                        </form>
                    </div>

                <?php endif; ?>

            <?php else: ?>
                <div class="alert alert-success text-dark">
                    <i class="fas fa-truck"></i> Pesanan COD Siap Dikirim.<br>
                    Siapkan uang tunai saat kurir datang.
                </div>
            <?php endif; ?>

        <?php endif; ?>


        <?php if ($pesanan->status_pesanan === 'diproses'): ?>
            <div class="alert alert-success text-dark mt-3">
                <i class="fas fa-box"></i> Pesanan sedang dikemas.
            </div>
        <?php endif; ?>

        <hr class="bg-secondary mt-4">
        
        <a href="<?= base_url('akun/pesanan'); ?>" class="btn btn-outline-light w-100 pixel-btn">
          ← KEMBALI
        </a>
      </div>

    </div>
  </div>

</section>