<?php
/**
 * ==========================================================
 * RIWAYAT PESANAN CUSTOMER - ZETTARIG
 * ==========================================================
 */
?>

<!-- HEADER -->
<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-2">RIWAYAT PESANAN</h1>
    <p class="text-muted mb-0">
      Daftar pesanan yang pernah kamu buat
    </p>
  </div>
</section>

<!-- CONTENT -->
<section class="container py-5">

  <?php if (!empty($pesanan)): ?>

    <div class="table-responsive">
      <table class="table table-dark table-bordered align-middle">
        <thead class="text-center">
          <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($pesanan as $p): ?>
            <tr>
              <td class="text-center">
                <a href="<?= base_url('akun/pesanan/detail/'.$p->id_penjualan); ?>">
                    #<?= $p->id_penjualan; ?>
                </a>
            </td>

              <td>
                <?= date('d M Y H:i', strtotime($p->tanggal_pesanan)); ?>
              </td>
              <td class="text-end">
                Rp <?= number_format($p->total_harga, 0, ',', '.'); ?>
              </td>
              <td class="text-center">

                <?php
                  switch ($p->status_pesanan) {
                    case 'baru':
                      echo '<span class="badge bg-warning">Baru</span>';
                      break;
                    case 'diproses':
                      echo '<span class="badge bg-info">Diproses</span>';
                      break;
                    case 'dikirim':
                      echo '<span class="badge bg-primary">Dikirim</span>';
                      break;
                    case 'selesai':
                      echo '<span class="badge bg-success">Selesai</span>';
                      break;
                    case 'dibatalkan':
                      echo '<span class="badge bg-danger">Dibatalkan</span>';
                      break;
                    default:
                      echo '<span class="badge bg-secondary">-</span>';
                  }
                ?>

              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
    </div>

    <a href="<?= base_url('akun'); ?>" class="btn btn-outline-light mt-4">
      ← Kembali ke Akun
    </a>

  <?php else: ?>

    <div class="text-center text-muted">
      <p>Belum ada pesanan.</p>
      <a href="<?= base_url('produk'); ?>" class="pixel-btn mt-3">
        MULAI BELANJA
      </a>
    </div>

  <?php endif; ?>

</section>
