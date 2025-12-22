<?php
/**
 * ==========================================================
 * PRODUK KATALOG - ZETTARIG (RETRO THEME)
 * ==========================================================
 */
?>

<section class="py-5 bg-dark border-bottom border-secondary position-relative overflow-hidden">
    <div style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(56,189,248,0.2) 0%, rgba(0,0,0,0) 70%); z-index: 0;"></div>

    <div class="container text-center position-relative" style="z-index: 1;">
        <span class="badge bg-primary pixel-font mb-2 rounded-0 border border-light">DATABASE V.2.0</span>
        <h1 class="pixel-font text-white mb-3" style="text-shadow: 4px 4px 0 #000;">HARDWARE INVENTORY</h1>
        <p class="text-secondary mx-auto" style="font-family: 'VT323', monospace; font-size: 1.4rem; max-width: 600px;">
            Akses database komponen. Gunakan filter untuk menemukan spesifikasi yang dibutuhkan.
        </p>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 100vh;">
    <div class="container">

        <div class="pixel-card bg-dark p-4 mb-5 border-secondary">
            <div class="mb-2 text-success" style="font-family: 'VT323';">
                <i class="fas fa-terminal me-2"></i> root@zettarig:~/search_query$
            </div>
            
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="text-muted small mb-1">KEYWORD</label>
                    <div class="input-group">
                        <span class="input-group-text bg-secondary text-white border-dark rounded-0"><i class="fas fa-search"></i></span>
                        <input type="text" name="q" value="<?= htmlspecialchars($keyword ?? ''); ?>" 
                               class="form-control bg-dark text-white border-secondary rounded-0 shadow-none" 
                               placeholder="Cari GPU, CPU..." style="font-family: 'VT323'; font-size: 1.2rem;">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="text-muted small mb-1">CATEGORY</label>
                    <select name="kategori" class="form-select bg-dark text-white border-secondary rounded-0 shadow-none" style="font-family: 'VT323'; font-size: 1.2rem;">
                        <option value="">[ ALL CATEGORIES ]</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k->id_kategori; ?>" <?= ($kategori_id == $k->id_kategori) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($k->nama_kategori); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <button class="pixel-btn w-100 text-center">
                        EXECUTE <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row g-4">
            <?php if (!empty($produk)): ?>
                <?php foreach ($produk as $p): ?>
                    <?php
                        $gambar = (!empty($p->gambar_produk) && file_exists(FCPATH.'assets/uploads/produk/'.$p->gambar_produk))
                            ? base_url('assets/uploads/produk/'.$p->gambar_produk)
                            : 'https://dummyimage.com/400x400/000/fff&text=NO+IMG';
                        
                        $stok_habis = ($p->stok <= 0);
                    ?>

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card pixel-card h-100 bg-dark text-white border-0 position-relative hover-up">
                            
                            <div class="position-absolute top-0 start-0 m-2" style="z-index: 5;">
                                <?php if($stok_habis): ?>
                                    <span class="badge bg-danger rounded-0 border border-dark text-dark">OUT OF STOCK</span>
                                <?php else: ?>
                                    <span class="badge bg-success rounded-0 border border-dark text-dark">READY</span>
                                <?php endif; ?>
                            </div>

                            <a href="<?= base_url('produk/'.$p->slug_produk); ?>" class="d-block bg-white border-bottom border-4 border-dark p-3 position-relative overflow-hidden" style="height: 220px;">
                                <img src="<?= $gambar; ?>" class="img-fluid w-100 h-100" alt="<?= htmlspecialchars($p->nama_produk); ?>" style="object-fit: contain;">
                            </a>

                            <div class="card-body d-flex flex-column p-3">
                                <div class="mb-2">
                                    <small class="text-info pixel-font" style="font-size: 0.6rem;">
                                        <?= strtoupper($p->nama_kategori); ?>
                                    </small>
                                </div>

                                <h5 class="card-title pixel-font text-truncate mb-1" style="font-size: 0.9rem; line-height: 1.4;">
                                    <a href="<?= base_url('produk/'.$p->slug_produk); ?>" class="text-white text-decoration-none">
                                        <?= htmlspecialchars($p->nama_produk); ?>
                                    </a>
                                </h5>

                                <div class="mt-auto pt-3 border-top border-secondary">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-warning fw-bold" style="font-family: 'VT323'; font-size: 1.5rem;">
                                            Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?>
                                        </span>
                                        <a href="<?= base_url('produk/'.$p->slug_produk); ?>" class="btn btn-sm btn-dark border border-secondary rounded-0">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <div class="pixel-card bg-dark p-5 d-inline-block">
                        <i class="fas fa-search fa-3x text-secondary mb-3"></i>
                        <h3 class="pixel-font text-white">DATA NOT FOUND</h3>
                        <p class="text-muted">Coba kata kunci lain atau reset filter.</p>
                        <a href="<?= base_url('produk'); ?>" class="pixel-btn bg-secondary text-white mt-3">RESET SYSTEM</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($pagination)): ?>
            <div class="mt-5 d-flex justify-content-center">
                <nav>
                    <?= $pagination; ?> 
                </nav>
            </div>
        <?php endif; ?>

    </div>
</section>