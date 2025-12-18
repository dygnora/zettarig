<?php
/**
 * ==========================================================
 * DETAIL PRODUK - ZETTARIG
 * ==========================================================
 * Style:
 * - Bootstrap utility
 * - pixel-font, pixel-card, pixel-btn
 * - bg-grid
 * - Add to Cart ready
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
    <h1 class="pixel-font mb-2">
      <?= htmlspecialchars($produk->nama_produk); ?>
    </h1>
    <p class="text-muted mb-0">
      <?= htmlspecialchars($produk->nama_brand); ?>
      •
      <?= htmlspecialchars($produk->nama_kategori); ?>
    </p>
  </div>
</section>

<!-- ======================================================
     DETAIL CONTENT
====================================================== -->
<section class="container py-5">

  <div class="row g-5 align-items-start">

    <!-- ================== GAMBAR ================== -->
    <div class="col-md-6 text-center">

      <?php
        $gambar = (!empty($produk->gambar_produk) && file_exists(FCPATH.'assets/uploads/produk/'.$produk->gambar_produk))
          ? base_url('assets/uploads/produk/'.$produk->gambar_produk)
          : base_url('assets/images/no-image.png');
      ?>

      <div class="card bg-dark pixel-card p-4">
        <img
          src="<?= $gambar; ?>"
          alt="<?= htmlspecialchars($produk->nama_produk); ?>"
          class="img-fluid"
          style="max-height:420px; object-fit:contain;"
        >
      </div>

    </div>

    <!-- ================== INFO ================== -->
    <div class="col-md-6">

      <div class="card bg-dark text-light pixel-card h-100 p-4">

        <!-- HARGA -->
        <h3 class="mb-3">
          Rp <?= number_format($produk->harga_jual, 0, ',', '.'); ?>
        </h3>

        <!-- STOK -->
        <?php if ($produk->stok > 0): ?>
          <span class="badge bg-success mb-3">
            Stok tersedia (<?= (int)$produk->stok; ?>)
          </span>
        <?php else: ?>
          <span class="badge bg-danger mb-3">
            Stok habis
          </span>
        <?php endif; ?>

        <!-- DESKRIPSI -->
        <div class="mb-4 text-muted">
          <?= !empty($produk->deskripsi)
            ? nl2br(htmlspecialchars($produk->deskripsi))
            : '<em>Deskripsi belum tersedia.</em>'; ?>
        </div>

        <!-- ACTION -->
        <div class="d-flex flex-wrap gap-3">

          <?php if ($produk->stok > 0): ?>
            <a href="<?= base_url('cart/add/'.$produk->slug_produk); ?>"
               class="pixel-btn">
              TAMBAH KE KERANJANG
            </a>
          <?php else: ?>
            <button class="pixel-btn disabled">
              STOK HABIS
            </button>
          <?php endif; ?>

          <a href="<?= base_url('produk'); ?>"
             class="btn btn-outline-light">
            Kembali
          </a>

        </div>

      </div>

    </div>

  </div>

</section>
