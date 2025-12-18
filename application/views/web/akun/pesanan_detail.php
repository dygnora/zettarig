<?php
/**
 * ==========================================================
 * DETAIL PESANAN CUSTOMER - ZETTARIG
 * ==========================================================
 */
?>

<!-- HEADER -->
<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-2">DETAIL PESANAN</h1>
    <p class="text-muted mb-0">
      Pesanan #<?= $pesanan->id_penjualan; ?>
    </p>
  </div>
</section>

<!-- CONTENT -->
<section class="container py-5">

  <!-- INFO PESANAN -->
  <div class="card bg-dark text-light pixel-card p-4 mb-4">
    <p class="mb-1"><strong>Tanggal</strong></p>
    <p class="text-muted">
      <?= date('d M Y H:i', strtotime($pesanan->tanggal_pesanan)); ?>
    </p>

    <p class="mb-1"><strong>Status</strong></p>
    <p>
      <?php
        switch ($pesanan->status_pesanan) {
          case 'baru':
            echo '<span class="badge bg-warning">Baru</span>'; break;
          case 'diproses':
            echo '<span class="badge bg-info">Diproses</span>'; break;
          case 'dikirim':
            echo '<span class="badge bg-primary">Dikirim</span>'; break;
          case 'selesai':
            echo '<span class="badge bg-success">Selesai</span>'; break;
          case 'dibatalkan':
            echo '<span class="badge bg-danger">Dibatalkan</span>'; break;
          default:
            echo '<span class="badge bg-secondary">-</span>';
        }
      ?>
    </p>
  </div>

  <!-- ITEM PESANAN -->
  <div class="card bg-dark text-light pixel-card p-4 mb-4">
    <h5 class="mb-3">Produk</h5>

    <div class="table-responsive">
      <table class="table table-dark table-bordered align-middle">
        <thead class="text-center">
          <tr>
            <th>Produk</th>
            <th width="100">Qty</th>
            <th width="160">Harga</th>
            <th width="160">Subtotal</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($pesanan->items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item->nama_produk); ?></td>
              <td class="text-center"><?= $item->qty; ?></td>
              <td class="text-end">
                Rp <?= number_format($item->harga_jual, 0, ',', '.'); ?>
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

  <a href="<?= base_url('akun/pesanan'); ?>" class="btn btn-outline-light">
    ← Kembali ke Riwayat Pesanan
  </a>

</section>
