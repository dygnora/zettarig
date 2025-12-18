<?php
/**
 * ==========================================================
 * PRODUK KATALOG - ZETTARIG
 * ==========================================================
 * Style:
 * - Bootstrap utility
 * - pixel-font, pixel-card, pixel-btn
 * - bg-grid (konsisten dengan home)
 */
?>

<!-- HEADER -->
<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-3">KATALOG PRODUK</h1>
    <p class="text-muted mb-0">
      Cari hardware terbaik sesuai kebutuhanmu
    </p>
  </div>
</section>

<!-- CONTENT -->
<section class="container py-5">

  <!-- FILTER BAR -->
  <form method="get" class="row g-2 align-items-end mb-4">

    <div class="col-md-5">
      <input type="text"
             name="q"
             value="<?= htmlspecialchars($keyword ?? ''); ?>"
             class="form-control"
             placeholder="Cari produk, brand, kategori...">
    </div>

    <div class="col-md-4">
      <select name="kategori" class="form-control">
        <option value="">Semua Kategori</option>
        <?php foreach ($kategori as $k): ?>
          <option value="<?= $k->id_kategori; ?>"
            <?= ($kategori_id == $k->id_kategori) ? 'selected' : ''; ?>>
            <?= htmlspecialchars($k->nama_kategori); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3">
      <button class="pixel-btn w-100">FILTER</button>
    </div>

  </form>

  <!-- GRID PRODUK -->
  <div class="row g-4">

    <?php if (!empty($produk)): ?>
      <?php foreach ($produk as $p): ?>

        <?php
          $gambar = (!empty($p->gambar_produk) && file_exists(FCPATH.'assets/uploads/produk/'.$p->gambar_produk))
            ? base_url('assets/uploads/produk/'.$p->gambar_produk)
            : base_url('assets/images/no-image.png');

          $stok_habis = ($p->stok <= 0);
        ?>

        <div class="col-sm-6 col-md-4 col-lg-3">

          <div class="card bg-dark text-light pixel-card h-100">

            <a href="<?= base_url('produk/'.$p->slug_produk); ?>">
              <img src="<?= $gambar; ?>"
                   class="card-img-top"
                   alt="<?= htmlspecialchars($p->nama_produk); ?>"
                   style="aspect-ratio:1/1; object-fit:contain; background:#0f172a;">
            </a>

            <div class="card-body d-flex flex-column">

              <small class="text-muted mb-1">
                <?= htmlspecialchars($p->nama_brand); ?> • <?= htmlspecialchars($p->nama_kategori); ?>
              </small>

              <h6 class="mb-2" style="min-height:40px;">
                <?= htmlspecialchars($p->nama_produk); ?>
              </h6>

              <strong class="mb-3">
                Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?>
              </strong>

              <?php if ($stok_habis): ?>
                <span class="badge bg-danger mb-3">Stok Habis</span>
              <?php else: ?>
                <span class="badge bg-success mb-3">Stok Tersedia</span>
              <?php endif; ?>

              <a href="<?= base_url('produk/'.$p->slug_produk); ?>"
                 class="pixel-btn mt-auto <?= $stok_habis ? 'disabled' : ''; ?>">
                <?= $stok_habis ? 'HABIS' : 'LIHAT DETAIL'; ?>
              </a>

            </div>
          </div>

        </div>

      <?php endforeach; ?>

    <?php else: ?>

      <div class="col-12 text-center text-muted">
        <p>Produk tidak ditemukan.</p>
      </div>

    <?php endif; ?>

  </div>

  <!-- PAGINATION -->
  <?php if (!empty($pagination)): ?>
    <div class="mt-5">
      <?= $pagination; ?>
    </div>
  <?php endif; ?>

</section>
