<?php
/**
 * ==========================================================
 * CART PAGE - ZETTARIG
 * ==========================================================
 * - Session based (CI Cart)
 * - Pixel style konsisten
 * - Siap ke checkout
 */
?>

<!-- ======================================================
     FLASH MESSAGE
====================================================== -->
<div class="container mt-4">

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
      <?= $this->session->flashdata('success'); ?>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
      <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

</div>

<!-- ======================================================
     HEADER
====================================================== -->
<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-2">KERANJANG</h1>
    <p class="text-muted mb-0">
      Periksa kembali produk sebelum checkout
    </p>
  </div>
</section>

<!-- ======================================================
     CART CONTENT
====================================================== -->
<section class="container py-5">

<?php if ($this->cart->total_items() > 0): ?>

  <div class="table-responsive mb-4">
    <table class="table table-dark table-bordered align-middle">
      <thead>
        <tr class="text-center">
          <th>Produk</th>
          <th width="120">Harga</th>
          <th width="100">Qty</th>
          <th width="140">Subtotal</th>
          <th width="80">Aksi</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($this->cart->contents() as $item): ?>

          <?php
            $gambar = (!empty($item['options']['gambar']) &&
                       file_exists(FCPATH.'assets/uploads/produk/'.$item['options']['gambar']))
              ? base_url('assets/uploads/produk/'.$item['options']['gambar'])
              : base_url('assets/images/no-image.png');
          ?>

          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="<?= $gambar; ?>"
                     alt="<?= htmlspecialchars($item['name']); ?>"
                     style="width:60px;height:60px;object-fit:contain;">
                <div>
                  <strong><?= htmlspecialchars($item['name']); ?></strong><br>
                  <small class="text-muted">
                    <?= htmlspecialchars($item['options']['brand'] ?? ''); ?>
                  </small>
                </div>
              </div>
            </td>

            <td class="text-end">
              Rp <?= number_format($item['price'], 0, ',', '.'); ?>
            </td>

            <!-- UPDATE QTY -->
            <td>
              <form action="<?= base_url('cart/update'); ?>" method="post">
                <input type="hidden" name="rowid" value="<?= $item['rowid']; ?>">
                <input type="number"
                       name="qty"
                       value="<?= $item['qty']; ?>"
                       min="1"
                       class="form-control form-control-sm"
                       onchange="this.form.submit()">
              </form>
            </td>

            <td class="text-end">
              Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?>
            </td>

            <!-- REMOVE -->
            <td class="text-center">
              <a href="<?= base_url('cart/remove/'.$item['rowid']); ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Hapus item ini?')">
                ✕
              </a>
            </td>
          </tr>

        <?php endforeach; ?>

      </tbody>
    </table>
  </div>

  <!-- TOTAL -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Total</h5>
    <h4>
      Rp <?= number_format($this->cart->total(), 0, ',', '.'); ?>
    </h4>
  </div>

  <!-- ACTION -->
  <div class="d-flex justify-content-between flex-wrap gap-3">
    <a href="<?= base_url('produk'); ?>" class="btn btn-outline-light">
      ← Lanjut Belanja
    </a>

    <a href="<?= base_url('checkout'); ?>" class="pixel-btn">
      CHECKOUT
    </a>
  </div>

<?php else: ?>

  <div class="text-center text-muted">
    <p>Keranjang masih kosong.</p>
    <a href="<?= base_url('produk'); ?>" class="pixel-btn mt-3">
      MULAI BELANJA
    </a>
  </div>

<?php endif; ?>

</section>
