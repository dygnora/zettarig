<?php
/**
 * ==========================================================
 * KATALOG PRODUK - ZETTARIG (TERMINAL FILTER REDESIGN)
 * ==========================================================
 */
?>

<style>
    /* === TERMINAL FILTER STYLE === */
    .terminal-box {
        background-color: #0a0a0a; /* Hitam Pekat */
        border: 1px solid #333;
        box-shadow: 5px 5px 0 #000;
        font-family: 'VT323', monospace;
    }
    
    .terminal-header {
        background-color: #1a1a1a;
        padding: 10px 15px;
        border-bottom: 1px solid #333;
        color: #22c55e; /* Terminal Green */
        font-family: 'Press Start 2P';
        font-size: 0.6rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .term-group {
        padding: 15px;
        border-bottom: 1px dashed #333;
    }
    .term-group:last-child { border-bottom: none; }

    .term-label {
        color: #64748b;
        font-size: 1rem;
        display: block;
        margin-bottom: 5px;
    }

    /* Input ala Command Line */
    .term-input-wrapper {
        display: flex;
        align-items: center;
        background: #000;
        border: 1px solid #333;
        padding: 5px 10px;
    }
    .term-input-wrapper:focus-within {
        border-color: #22c55e;
        box-shadow: 0 0 5px rgba(34, 197, 94, 0.2);
    }
    .term-prompt {
        color: #22c55e;
        margin-right: 8px;
        user-select: none;
    }
    .term-input {
        background: transparent;
        border: none;
        color: #fff;
        width: 100%;
        font-family: 'VT323', monospace;
        font-size: 1.2rem;
        outline: none;
    }
    .term-input::placeholder { color: #333; }
    .term-select {
        background: #000;
        color: #fff;
        border: none;
        width: 100%;
        font-family: 'VT323', monospace;
        font-size: 1.2rem;
        outline: none;
        cursor: pointer;
    }

    /* Sticky Desktop */
    @media (min-width: 992px) {
        .sticky-filter {
            position: sticky;
            top: 100px;
            z-index: 10;
        }
    }
</style>

<section class="bg-dark border-bottom border-secondary py-5 position-relative overflow-hidden">
    <div class="container text-center position-relative" style="z-index: 1;">
        <span class="badge bg-primary pixel-font mb-2 rounded-0 border border-light">DATABASE V.2.0</span>
        <h1 class="pixel-font text-white mb-3" style="text-shadow: 4px 4px 0 #000;">HARDWARE INVENTORY</h1>
        <p class="text-secondary mx-auto" style="font-family: 'VT323', monospace; font-size: 1.4rem;">
            Akses database komponen. Temukan spesifikasi tempur Anda.
        </p>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 100vh;">
    <div class="container">
        <div class="row g-4">

            <div class="col-lg-3">
                <div class="terminal-box sticky-filter">
                    
                    <div class="terminal-header">
                        <div class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 8px; height: 8px;"></div>
                        <span>FILTER_CONFIG.EXE</span>
                    </div>

                    <form method="get" action="<?= base_url('produk'); ?>">
                        
                        <div class="term-group">
                            <label class="term-label">// SEARCH_QUERY</label>
                            <div class="term-input-wrapper">
                                <span class="term-prompt">></span>
                                <input type="text" name="q" class="term-input" 
                                       value="<?= htmlspecialchars($filters['keyword'] ?? ''); ?>" 
                                       placeholder="Geforce...">
                            </div>
                        </div>

                        <div class="term-group">
                            <label class="term-label">// TARGET_CATEGORY</label>
                            <div class="term-input-wrapper">
                                <span class="term-prompt">#</span>
                                <select name="kategori" class="term-select">
                                    <option value="">[ SELECT ALL ]</option>
                                    <?php foreach ($kategori_list as $k): ?>
                                        <option value="<?= $k->id_kategori; ?>" <?= (isset($filters['kategori']) && $filters['kategori'] == $k->id_kategori) ? 'selected' : ''; ?>>
                                            <?= strtoupper($k->nama_kategori); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="term-group">
                            <label class="term-label">// PRICE_LIMITS (IDR)</label>
                            
                            <div class="term-input-wrapper mb-2">
                                <span class="term-prompt" style="color: var(--pixel-blue);">Min:</span>
                                <input type="number" name="min_price" class="term-input" 
                                       placeholder="0" value="<?= htmlspecialchars($filters['min_price'] ?? ''); ?>">
                            </div>
                            
                            <div class="term-input-wrapper">
                                <span class="term-prompt" style="color: var(--pixel-orange);">Max:</span>
                                <input type="number" name="max_price" class="term-input" 
                                       placeholder="Unlimited" value="<?= htmlspecialchars($filters['max_price'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="term-group bg-black">
                            <button type="submit" class="pixel-btn w-100 text-center mb-2 border-0 bg-success text-dark">
                                <i class="fas fa-terminal me-2"></i> EXECUTE
                            </button>
                            <a href="<?= base_url('produk'); ?>" class="btn btn-outline-secondary w-100 rounded-0 pixel-font" style="font-size: 0.6rem;">
                                [ RESET ]
                            </a>
                        </div>

                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                
                <?php if (!empty($produk)): ?>
                    <div class="row g-3">
                        <?php foreach ($produk as $p): ?>
                            <?php
                                // Logic Gambar
                                $img_path = FCPATH . 'assets/uploads/produk/' . $p->gambar_produk;
                                $img_url  = (!empty($p->gambar_produk) && file_exists($img_path)) 
                                            ? base_url('assets/uploads/produk/' . $p->gambar_produk) 
                                            : 'https://placehold.co/400x400/000000/FFFFFF?text=NO+IMG';
                                
                                $is_habis = ($p->stok <= 0);
                            ?>

                            <div class="col-6 col-md-4">
                                <div class="pixel-card h-100 bg-dark text-white border-secondary position-relative hover-up d-flex flex-column">
                                    
                                    <div class="position-absolute top-0 start-0 m-2" style="z-index: 5;">
                                        <?php if($is_habis): ?>
                                            <span class="badge bg-danger rounded-0 border border-dark text-white pixel-font">SOLD OUT</span>
                                        <?php else: ?>
                                            <span class="badge bg-success rounded-0 border border-dark text-white pixel-font">READY</span>
                                        <?php endif; ?>
                                    </div>

                                    <a href="<?= base_url('produk/'.$p->slug_produk); ?>" class="d-block bg-white border-bottom border-secondary p-3 position-relative overflow-hidden" style="height: 200px;">
                                        <img src="<?= $img_url; ?>" class="img-fluid w-100 h-100" alt="<?= htmlspecialchars($p->nama_produk); ?>" style="object-fit: contain;">
                                    </a>

                                    <div class="p-3 d-flex flex-column flex-grow-1">
                                        <div class="mb-1">
                                            <span class="text-info pixel-font" style="font-size: 0.5rem;">
                                                <?= isset($p->nama_kategori) ? strtoupper($p->nama_kategori) : 'HARDWARE'; ?>
                                            </span>
                                        </div>

                                        <h5 class="pixel-font text-truncate mb-2" style="font-size: 0.8rem; line-height: 1.4;">
                                            <a href="<?= base_url('produk/'.$p->slug_produk); ?>" class="text-white text-decoration-none">
                                                <?= htmlspecialchars($p->nama_produk); ?>
                                            </a>
                                        </h5>

                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-warning fw-bold" style="font-family: 'VT323'; font-size: 1.4rem;">
                                                    Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?>
                                                </span>
                                            </div>
                                            
                                            <a href="<?= $is_habis ? '#' : base_url('cart/add/'.$p->slug_produk); ?>" 
                                               class="btn btn-sm w-100 rounded-0 pixel-font mt-2 <?= $is_habis ? 'btn-secondary disabled' : 'btn-outline-light'; ?>"
                                               style="font-size: 0.6rem;">
                                                <?= $is_habis ? 'OUT OF STOCK' : '+ ADD TO CART'; ?>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-5 d-flex justify-content-center">
                        <?= $pagination; ?>
                    </div>

                <?php else: ?>

                    <div class="text-center py-5">
                        <div class="pixel-card bg-dark p-5 d-inline-block border-secondary">
                            <i class="fas fa-search fa-3x text-secondary mb-3 opacity-50"></i>
                            <h3 class="pixel-font text-white mb-2">DATA NOT FOUND</h3>
                            <p class="text-secondary" style="font-family: 'VT323'; font-size: 1.2rem;">
                                Item dengan kriteria tersebut tidak ditemukan.
                            </p>
                            <a href="<?= base_url('produk'); ?>" class="pixel-btn bg-warning text-dark mt-3">
                                RESET SYSTEM
                            </a>
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</section>