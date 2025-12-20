<?php
/**
 * ==========================================================
 * CHECKOUT PAGE - ZETTARIG
 * ==========================================================
 */
?>

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

<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-2">CHECKOUT</h1>
    <p class="text-muted mb-0">Lengkapi data untuk menyelesaikan pesanan</p>
  </div>
</section>

<section class="container py-5">

  <form action="<?= base_url('checkout/process'); ?>" method="post">

    <div class="row g-5">

      <!-- DATA CUSTOMER -->
      <div class="col-md-6">
        <div class="card bg-dark text-light pixel-card p-4 h-100">

          <h5 class="mb-4">Data Customer</h5>

          <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control"
                   value="<?= htmlspecialchars($this->session->userdata('customer_nama')); ?>"
                   disabled>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control"
                   value="<?= htmlspecialchars($this->session->userdata('customer_email')); ?>"
                   disabled>
          </div>

          <div class="mb-3">
            <label>Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" required></textarea>
          </div>

        </div>
      </div>

      <!-- RINGKASAN -->
      <div class="col-md-6">
        <div class="card bg-dark text-light pixel-card p-4 h-100">

          <h5 class="mb-4">Ringkasan Pesanan</h5>

          <ul class="list-group list-group-flush mb-4">
            <?php foreach ($this->cart->contents() as $item): ?>
              <li class="list-group-item bg-dark text-light d-flex justify-content-between">
                <div>
                  <?= htmlspecialchars($item['name']); ?>
                  <small class="text-muted d-block">
                    Qty: <?= $item['qty']; ?>
                  </small>
                </div>
                <div>
                  Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>

          <div class="d-flex justify-content-between mb-3">
            <strong>Total</strong>
            <strong>Rp <?= number_format($this->cart->total(), 0, ',', '.'); ?></strong>
          </div>

          <!-- METODE PEMBAYARAN -->
          <div class="mb-4">
            <label class="form-label">Metode Pembayaran</label>

            <div class="form-check">
              <input class="form-check-input" type="radio"
                     name="metode_pembayaran"
                     value="transfer" checked>
              <label class="form-check-label">Transfer Bank</label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio"
                     name="metode_pembayaran"
                     value="cod">
              <label class="form-check-label">COD</label>
            </div>
          </div>

          <button type="submit" class="pixel-btn w-100">
            BUAT PESANAN
          </button>

        </div>
      </div>

    </div>

  </form>

</section>
