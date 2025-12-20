<?php
/**
 * ==========================================================
 * DETAIL PESANAN CUSTOMER - ZETTARIG
 * ==========================================================
 * FLOW TRANSFER FINAL:
 * - dibuat / menunggu_pembayaran  -> boleh upload
 * - menunggu_verifikasi           -> TIDAK boleh upload
 * - diproses / selesai            -> read-only
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

        <p class="mb-1"><strong>Status</strong></p>
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
              <?php foreach ($pesanan->items as $item): ?>
                <tr>
                  <td><?= htmlspecialchars($item->nama_produk); ?></td>
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
          <strong>Total</strong>
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
            // Ambil data timeline terakhir
            $last_timeline = !empty($timeline) ? end($timeline) : null;
            
            // Cek apakah status terakhir mengandung kata 'Ditolak'
            if ($last_timeline && strpos(strtolower($last_timeline->status_tahap), 'ditolak') !== false): 
        ?>
            <div class="alert alert-danger mb-3" style="border: 2px solid #ff4444; background: rgba(255,0,0,0.2); color: #ffadad;">
                <i class="fas fa-exclamation-circle"></i> <strong>Pembayaran Ditolak!</strong><br>
                <small>Alasan: <?= $last_timeline->catatan; ?></small>
            </div>
        <?php endif; ?>

        <?php if (
            $pesanan->metode_pembayaran === 'transfer' &&
            in_array($pesanan->status_pesanan, ['dibuat', 'menunggu_pembayaran'])
        ): ?>
          <div class="alert alert-warning text-dark">
            <small>Silakan transfer ke rekening:<br>
            <strong>BCA 1234567890</strong> a.n Zettarig<br>
            Lalu upload bukti transfer di bawah ini.</small>
          </div>

          <a href="<?= base_url('pembayaran/upload/'.$pesanan->id_penjualan); ?>"
             class="btn btn-warning w-100 mb-3"
             style="font-family: 'Press Start 2P'; font-size: 10px; padding: 12px;">
             UPLOAD BUKTI
          </a>
        <?php endif; ?>

        <?php if (
            $pesanan->metode_pembayaran === 'transfer' &&
            $pesanan->status_pesanan === 'menunggu_verifikasi'
        ): ?>
          <div class="alert alert-info text-dark">
            <i class="fas fa-clock"></i> Bukti transfer sudah dikirim.<br>
            Silakan menunggu verifikasi dari admin.
          </div>
        <?php endif; ?>

        <?php if ($pesanan->status_pesanan === 'diproses'): ?>
            <div class="alert alert-success text-dark">
                <i class="fas fa-check-circle"></i> Pembayaran Lunas.
            </div>
        <?php endif; ?>

        <hr class="bg-secondary">
        
        <a href="<?= base_url('akun/pesanan'); ?>" class="btn btn-outline-light w-100">
          ← Kembali
        </a>
      </div>

    </div>
  </div>

</section>