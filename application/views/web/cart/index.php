<?php
/**
 * ==========================================================
 * CART PAGE - ZETTARIG (INVENTORY SYSTEM STYLE)
 * ==========================================================
 */
?>

<section class="bg-dark border-bottom border-secondary py-4">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h5 class="pixel-font text-white mb-0" style="font-size: 1rem;">
                    <i class="fas fa-shopping-cart me-2 text-warning"></i> INVENTORY CHECK
                </h5>
                <small class="text-secondary" style="font-family: 'VT323'; font-size: 1rem;">
                    System Status: <span class="text-success">ONLINE</span> // Items: <?= $this->cart->total_items(); ?>
                </small>
            </div>
            <div class="d-none d-md-block">
                <a href="<?= base_url('produk'); ?>" class="btn btn-sm btn-outline-light rounded-0 pixel-font" style="font-size: 0.6rem;">
                    + ADD MORE HARDWARE
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-grid py-5" style="min-height: 80vh;">
    <div class="container">

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success rounded-0 border-2 border-dark mb-4 pixel-font fs-6">
                <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger rounded-0 border-2 border-dark mb-4 pixel-font fs-6">
                <i class="fas fa-times-circle me-2"></i> <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->cart->total_items() > 0): ?>
            
            <div class="row g-4">
                
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-3">
                        
                        <?php foreach ($this->cart->contents() as $item): ?>
                            <?php
                                // Ambil Gambar
                                $gambar = (!empty($item['options']['gambar']) && file_exists(FCPATH.'assets/uploads/produk/'.$item['options']['gambar']))
                                    ? base_url('assets/uploads/produk/'.$item['options']['gambar'])
                                    : base_url('assets/images/no-image.png');
                                
                                // [FIX ERROR] Ambil Slug dari options dengan operator ?? (Null Coalescing)
                                // Jika slug tidak ada (data lama), default ke string kosong
                                $slug = $item['options']['slug'] ?? ''; 
                            ?>

                            <div class="pixel-card bg-dark p-3 position-relative">
                                <div class="row align-items-center">
                                    
                                    <div class="col-3 col-md-2">
                                        <div class="bg-white p-1 border border-2 border-secondary">
                                            <img src="<?= $gambar; ?>" alt="Item" class="img-fluid" style="aspect-ratio: 1/1; object-fit: contain;">
                                        </div>
                                    </div>

                                    <div class="col-9 col-md-5">
                                        <small class="text-info pixel-font" style="font-size: 0.6rem;">
                                            <?= strtoupper($item['options']['brand'] ?? 'COMPONENT'); ?>
                                        </small>
                                        <h5 class="text-white pixel-font text-truncate mt-1 mb-1" style="font-size: 0.9rem;">
                                            <a href="<?= base_url('produk/'.$slug); ?>" class="text-white text-decoration-none">
                                                <?= htmlspecialchars($item['name']); ?>
                                            </a>
                                        </h5>
                                        <div class="text-secondary" style="font-family: 'VT323'; font-size: 1.1rem;">
                                            @ Rp <?= number_format($item['price'], 0, ',', '.'); ?>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-5 mt-3 mt-md-0">
                                        <div class="d-flex align-items-center justify-content-between justify-content-md-end gap-4">
                                            
                                            <form action="<?= base_url('cart/update'); ?>" method="post" class="d-flex align-items-center">
                                                <input type="hidden" name="rowid" value="<?= $item['rowid']; ?>">
                                                <div class="input-group input-group-sm" style="width: 100px;">
                                                    <span class="input-group-text bg-secondary border-secondary text-white rounded-0">QTY</span>
                                                    <input type="number" name="qty" value="<?= $item['qty']; ?>" min="1" 
                                                           class="form-control bg-black text-white border-secondary text-center rounded-0 font-monospace"
                                                           onchange="this.form.submit()">
                                                </div>
                                            </form>

                                            <div class="text-end">
                                                <small class="d-block text-muted" style="font-size: 0.6rem;">SUBTOTAL</small>
                                                <span class="text-warning fw-bold" style="font-family: 'VT323'; font-size: 1.4rem;">
                                                    <?= number_format($item['subtotal'], 0, ',', '.'); ?>
                                                </span>
                                            </div>

                                            <a href="<?= base_url('cart/remove/'.$item['rowid']); ?>" 
                                               class="btn btn-outline-danger btn-sm rounded-0 border-2"
                                               onclick="return confirm('Eject hardware ini?')"
                                               title="Remove Item">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="pixel-card bg-white p-4 sticky-top" style="top: 100px;">
                        
                        <h5 class="pixel-font text-dark border-bottom border-dark pb-3 mb-3">
                            ORDER SUMMARY
                        </h5>

                        <div class="d-flex justify-content-between mb-2 text-dark" style="font-family: 'VT323'; font-size: 1.2rem;">
                            <span>Total Item</span>
                            <span><?= $this->cart->total_items(); ?> Unit</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4 text-dark" style="font-family: 'VT323'; font-size: 1.2rem;">
                            <span>System Weight</span>
                            <span>Calculated at checkout</span>
                        </div>

                        <div class="bg-dark p-3 mb-4">
                            <small class="text-secondary d-block mb-1 pixel-font" style="font-size: 0.7rem;">ESTIMATED TOTAL</small>
                            <span class="text-warning display-6 fw-bold" style="font-family: 'VT323';">
                                Rp <?= number_format($this->cart->total(), 0, ',', '.'); ?>
                            </span>
                        </div>

                        <a href="<?= base_url('checkout'); ?>" class="pixel-btn w-100 text-center py-3 mb-3 bg-warning text-dark border-dark">
                            PROCEED TO CHECKOUT <i class="fas fa-arrow-right ms-2"></i>
                        </a>

                        <a href="<?= base_url('produk'); ?>" class="btn btn-outline-dark w-100 rounded-0 pixel-font" style="font-size: 0.7rem;">
                            CONTINUE SHOPPING
                        </a>

                    </div>
                </div>

            </div>

        <?php else: ?>

            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="pixel-card bg-dark p-5">
                        <i class="fas fa-box-open fa-5x text-secondary mb-4 opacity-50"></i>
                        <h2 class="pixel-font text-white mb-3">INVENTORY EMPTY</h2>
                        <p class="text-secondary mb-4" style="font-family: 'VT323'; font-size: 1.4rem;">
                            Tidak ada komponen yang terdeteksi dalam sistem penyimpanan Anda.
                        </p>
                        <a href="<?= base_url('produk'); ?>" class="pixel-btn bg-primary text-white">
                            BROWSE CATALOG <i class="fas fa-search ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</section>