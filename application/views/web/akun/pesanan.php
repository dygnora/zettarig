<?php
/**
 * ==========================================================
 * RIWAYAT PESANAN CUSTOMER - ZETTARIG (COMPLETE VERSION)
 * ==========================================================
 */
?>

<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-2">RIWAYAT PESANAN</h1>
    <p class="text-muted mb-0">
      Daftar pesanan yang pernah Anda buat
    </p>
  </div>
</section>

<section class="container py-5">

  <div class="row justify-content-center">
    <div class="col-md-10">

      <div class="card bg-dark text-light pixel-card p-4">

        <?php if (!empty($pesanan)): ?>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
              <thead>
                <tr class="text-uppercase small text-muted">
                  <th>ID Pesanan</th>
                  <th>Tanggal</th>
                  <th>Total</th>
                  <th class="text-center">Status</th>
                  <th class="text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($pesanan as $p): ?>
                  <tr>
                    <td>
                      <span class="text-white">#<?= $p->id_penjualan; ?></span>
                    </td>

                    <td>
                      <?= date('d M Y', strtotime($p->tanggal_pesanan)); ?><br>
                      <small class="text-muted"><?= date('H:i', strtotime($p->tanggal_pesanan)); ?> WIB</small>
                    </td>

                    <td>
                      <strong>Rp <?= number_format($p->total_harga, 0, ',', '.'); ?></strong>
                    </td>

                    <td class="text-center">
                      <?php
                        // LOGIKA STATUS LENGKAP
                        switch ($p->status_pesanan) {
                          // TAHAP PEMBAYARAN
                          case 'dibuat':
                          case 'menunggu_pembayaran':
                            echo '<span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle"></i> Bayar</span>';
                            break;

                          case 'menunggu_verifikasi':
                            echo '<span class="badge bg-info text-dark"><i class="fas fa-clock"></i> Verifikasi</span>';
                            break;

                          // TAHAP PROSES
                          case 'diproses':
                            echo '<span class="badge bg-primary">Diproses</span>';
                            break;
                          
                          // TAHAP PENGIRIMAN
                          case 'dikirim':
                            echo '<span class="badge bg-purple" style="background-color: #6f42c1;">Dikirim</span>';
                            break;

                          // SELESAI
                          case 'selesai':
                            echo '<span class="badge bg-success">Selesai</span>';
                            break;

                          // BATAL
                          case 'dibatalkan':
                            echo '<span class="badge bg-danger">Batal</span>';
                            break;

                          default:
                            echo '<span class="badge bg-secondary">-</span>';
                        }
                      ?>
                    </td>

                    <td class="text-end">
                      <a href="<?= base_url('akun/pesanan/detail/'.$p->id_penjualan); ?>" 
                         class="btn btn-sm btn-outline-light"
                         style="font-size: 12px;">
                         Detail <i class="fas fa-arrow-right ml-1"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>

              </tbody>
            </table>
          </div>

        <?php else: ?>

          <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
            <p class="text-muted">Belum ada pesanan.</p>
            <a href="<?= base_url('produk'); ?>" class="pixel-btn mt-2">
              MULAI BELANJA
            </a>
          </div>

        <?php endif; ?>

      </div>

      <div class="mt-4">
        <a href="<?= base_url('akun'); ?>" class="btn btn-link text-muted text-decoration-none">
          &larr; Kembali ke Profil
        </a>
      </div>

    </div>
  </div>

</section>