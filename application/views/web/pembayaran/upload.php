<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font">UPLOAD BUKTI TRANSFER</h1>
    <p class="text-muted">
      Pesanan #<?= $pesanan->id_penjualan; ?>
    </p>
  </div>
</section>

<section class="container py-5" style="max-width:520px;">

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
      <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <div class="card bg-dark text-light pixel-card p-4">

    <!-- FORM WAJIB multipart -->
    <form action="<?= base_url('pembayaran/process/'.$pesanan->id_penjualan); ?>"
          method="post"
          enctype="multipart/form-data">

      <!-- TOTAL -->
      <div class="mb-3">
        <label>Total Transfer</label>
        <input type="text"
               class="form-control"
               value="Rp <?= number_format($pesanan->total_harga,0,',','.'); ?>"
               readonly>
      </div>

      <!-- INPUT FILE ASLI (JANGAN DISAMARKAN BERLEBIHAN) -->
      <div class="mb-4">
        <label for="bukti_transfer" class="form-label">
          Bukti Transfer (JPG / PNG)
        </label>

        <input type="file"
               id="bukti_transfer"
               name="bukti_transfer"
               class="form-control"
               accept="image/png, image/jpeg"
               required>
      </div>

      <!-- SUBMIT -->
      <button type="submit" class="pixel-btn w-100">
        UPLOAD BUKTI TRANSFER
      </button>

    </form>
  </div>

</section>
