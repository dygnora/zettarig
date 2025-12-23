<?php
/**
 * ==========================================================
 * DETAIL PRODUK - ZETTARIG (RETRO THEME)
 * ==========================================================
 */

$gambar = (!empty($produk->gambar_produk) && file_exists(FCPATH.'assets/uploads/produk/'.$produk->gambar_produk))
    ? base_url('assets/uploads/produk/'.$produk->gambar_produk)
    : 'https://dummyimage.com/500x500/000/fff&text=NO+IMG';
?>

<div class="bg-dark border-bottom border-secondary py-2">
    <div class="container">
        <small class="text-success" style="font-family: 'VT323'; font-size: 1.1rem;">
            root@zettarig:~/inventory/<?= strtolower($produk->nama_kategori); ?>/<?= strtolower(substr($produk->slug_produk, 0, 15)); ?>...
        </small>
    </div>
</div>

<section class="bg-grid py-5" style="min-height: 90vh;">
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

        <div class="row g-lg-5">
            
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="pixel-card bg-white p-4 position-relative text-center">
                    <div class="position-absolute top-0 start-0 m-3 px-2 py-1 bg-dark text-white pixel-font" style="font-size: 0.7rem;">
                        <?= strtoupper($produk->nama_brand); ?>
                    </div>

                    <img src="<?= $gambar; ?>" alt="<?= htmlspecialchars($produk->nama_produk); ?>" class="img-fluid" style="max-height: 500px; object-fit: contain;">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="h-100 d-flex flex-column">
                    
                    <div class="border-bottom border-secondary pb-4 mb-4">
                        <h4 class="text-info pixel-font mb-2"><?= strtoupper($produk->nama_kategori); ?></h4>
                        <h1 class="pixel-font text-white mb-3" style="line-height: 1.4; font-size: 1.8rem;">
                            <?= htmlspecialchars($produk->nama_produk); ?>
                        </h1>
                        
                        <div class="d-inline-block bg-dark border border-secondary px-3 py-2">
                            <span class="text-warning display-4 fw-bold" style="font-family: 'VT323';">
                                Rp <?= number_format($produk->harga_jual, 0, ',', '.'); ?>
                            </span>
                        </div>
                    </div>

                    <div class="pixel-card bg-dark p-4 mb-4 flex-grow-1">
                        <h5 class="pixel-font text-white border-bottom border-secondary pb-2 mb-3" style="font-size: 0.8rem;">
                            <i class="fas fa-info-circle me-2"></i> SPECIFICATIONS
                        </h5>
                        <div class="text-secondary" style="font-family: 'VT323'; font-size: 1.3rem; line-height: 1.6;">
                            <?= !empty($produk->deskripsi) ? nl2br(htmlspecialchars($produk->deskripsi)) : 'Data spesifikasi belum tersedia.'; ?>
                        </div>
                    </div>

                    <div class="pixel-card bg-primary p-4 border-dark">
                        <div class="row align-items-center">
                            
                            <div class="col-md-4 mb-3 mb-md-0">
                                <span class="d-block text-white pixel-font mb-1" style="font-size: 0.7rem;">STOCK STATUS:</span>
                                <?php if ($produk->stok > 0): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-0 border border-white" style="width: 15px; height: 15px;"></div>
                                        <span class="ms-2 text-white fw-bold">AVAILABLE (<?= $produk->stok; ?>)</span>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger rounded-0 border border-white" style="width: 15px; height: 15px;"></div>
                                        <span class="ms-2 text-white fw-bold">OUT OF STOCK</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-8">
                                <?php if ($produk->stok > 0): ?>
                                    <div class="d-flex gap-2">
                                        <a href="<?= base_url('cart/add/'.$produk->slug_produk); ?>" 
                                           class="pixel-btn bg-white text-dark border-dark flex-fill text-center py-3"
                                           style="font-size: 0.8rem;">
                                            <i class="fas fa-cart-plus d-block d-md-none"></i> 
                                            <span class="d-none d-md-inline"><i class="fas fa-cart-plus me-1"></i> CART</span>
                                        </a>

                                        <a href="<?= base_url('cart/buy/'.$produk->slug_produk); ?>" 
                                           class="pixel-btn bg-warning text-dark border-dark flex-fill text-center py-3"
                                           style="font-size: 0.8rem;">
                                            <i class="fas fa-bolt me-1"></i> BUY NOW
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <button class="pixel-btn bg-secondary text-dark border-dark w-100 py-3 disabled" style="opacity: 0.6; cursor: not-allowed;">
                                        <i class="fas fa-ban me-2"></i> UNAVAILABLE
                                    </button>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="<?= base_url('produk'); ?>" class="text-decoration-none text-muted hover-underline" style="font-family: 'VT323'; font-size: 1.2rem;">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>