<style>
    /* --- REDESIGN PIXEL CARD --- */
    .pixel-product-card {
        background: #1a1a2e; /* Dark Blue Background */
        border: 4px solid #000;
        position: relative;
        transition: all 0.2s cubic-bezier(0, 0, 0.2, 1);
        box-shadow: 6px 6px 0px #000; /* Hard Shadow Retro */
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .pixel-product-card:hover {
        transform: translate(-4px, -4px);
        box-shadow: 10px 10px 0px #00ffff; /* Neon Cyan Shadow on Hover */
        border-color: #fff;
    }

    /* --- IMAGE CONTAINER FIX --- */
    .pixel-img-wrapper {
        height: 220px; /* Tinggi tetap agar rapi */
        width: 100%;
        background-color: #ffffff; /* Background putih agar komponen terlihat jelas */
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 4px solid #000;
        position: relative;
        overflow: hidden;
        padding: 20px; /* Jarak agar gambar tidak nempel pinggir */
    }

    .pixel-img-wrapper img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain; /* KUNCI: Agar gambar tidak gepeng/terpotong */
        filter: drop-shadow(0 5px 5px rgba(0,0,0,0.2));
        transition: transform 0.3s;
    }

    .pixel-product-card:hover .pixel-img-wrapper img {
        transform: scale(1.1); /* Zoom effect saat hover */
    }

    /* --- BADGES --- */
    .pixel-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        font-family: 'VT323', monospace;
        font-size: 1.1rem;
        padding: 2px 8px;
        border: 2px solid #000;
        z-index: 10;
        box-shadow: 3px 3px 0px rgba(0,0,0,0.5);
    }
    
    .bg-retro-success { background-color: #00ff00; color: #000; font-weight: bold; }
    .bg-retro-danger { background-color: #ff0055; color: #fff; font-weight: bold; }

    /* --- TEXT & BUTTONS --- */
    .card-info {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title-retro {
        font-family: 'Press Start 2P', cursive; /* Atau font pixel pilihan Anda */
        font-size: 0.7rem; /* Font pixel biasanya besar, jadi kecilkan rem-nya */
        line-height: 1.4;
        color: #fff;
        margin-bottom: 10px;
        min-height: 35px; /* Menjaga tinggi judul agar sejajar */
    }

    .price-tag {
        font-family: 'VT323', monospace;
        font-size: 1.6rem;
        color: #facc15; /* Kuning Retro */
        margin-bottom: 15px;
        display: block;
    }

    .btn-pixel-block {
        display: block;
        width: 100%;
        background: #3b82f6;
        color: white;
        border: 2px solid #000;
        font-family: 'VT323', monospace;
        font-size: 1.2rem;
        text-align: center;
        padding: 8px 0;
        text-decoration: none;
        margin-top: auto;
    }
    
    .btn-pixel-block:hover {
        background: #2563eb;
        color: #fff;
    }
</style>

<section class="position-relative bg-grid py-5 d-flex align-items-center"
         style="min-height: 90vh; overflow: hidden;">

    <!-- ORNAMEN GRADIENT -->
    <div style="position:absolute; top:-10%; right:-10%; width:500px; height:500px;
                background: radial-gradient(circle, rgba(56,189,248,0.2) 0%, rgba(0,0,0,0) 70%);
                z-index:0;"></div>

    <div style="position:absolute; bottom:-10%; left:-10%; width:400px; height:400px;
                background: radial-gradient(circle, rgba(251,146,60,0.15) 0%, rgba(0,0,0,0) 70%);
                z-index:0;"></div>

    <!-- GAMBAR PC (BACKGROUND HERO) -->
    <img src="<?= base_url('assets/web/img/hero-pc.png'); ?>"
         alt="Zettarig Custom Build"
         class="floating-anim"
         style="
            position: absolute;
            right: -5%;
            top: 10%;
            transform: translateY(-50%);
            width: 800px;
            max-width: none;
            opacity: 0.9;
            z-index: 1;
            filter: drop-shadow(0 0 40px rgba(255, 255, 255, 0.45)
         ">

    <!-- CONTENT -->
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center h-100">

            <!-- TEXT -->
            <div class="col-lg-7 text-center text-lg-start">

                <div class="d-inline-block px-2 py-1 mb-3 border border-2 border-primary
                            text-primary fw-bold"
                     style="background: rgba(15,23,42,0.9);">
                    <i class="fas fa-microchip me-2"></i> SYSTEM READY // V.2.0
                </div>

                <h1 class="pixel-font display-3 mb-3 text-white"
                    style="
                        line-height:1.2;
                        text-shadow: 4px 4px 0px #000;
                        position: relative;
                        z-index: 3;
                    ">
                    UNLOCK <span style="color: var(--pixel-blue);">ULTIMATE</span><br>
                    PERFORMANCE
                </h1>

                <p class="lead mb-4 text-secondary"
                   style="font-family:'VT323', monospace; font-size:1.5rem;">
                    Hardware PC High-End untuk Gaming & Workstation.<br>
                    Dirakit dengan presisi, dikirim dengan aman.
                </p>

                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    <a href="<?= base_url('produk'); ?>" class="pixel-btn fs-5">
                        <i class="fas fa-shopping-bag me-2"></i> SHOP NOW
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>


<section class="py-5 border-top border-bottom border-dark bg-dark">
    <div class="container">
        <div class="row g-4 text-center">
            
            <div class="col-6 col-md-3 border-end border-secondary">
                <h2 class="pixel-font text-warning mb-0">100%</h2>
                <p class="text-white mb-0" style="font-size: 0.9rem;">ORIGINAL PARTS</p>
            </div>
            
            <div class="col-6 col-md-3 border-end border-secondary d-none d-md-block">
                <h2 class="pixel-font text-info mb-0">24/7</h2>
                <p class="text-white mb-0" style="font-size: 0.9rem;">TECH SUPPORT</p>
            </div>
            
            <div class="col-6 col-md-3 border-end border-secondary">
                <h2 class="pixel-font text-success mb-0">FAST</h2>
                <p class="text-white mb-0" style="font-size: 0.9rem;">SHIPPING</p>
            </div>
            
            <div class="col-6 col-md-3">
                <h2 class="pixel-font text-danger mb-0">PRO</h2>
                <p class="text-white mb-0" style="font-size: 0.9rem;">CABLE MANAG.</p>
            </div>

        </div>
    </div>
</section>

<style>
    /* Desain Kartu Kategori */
    .category-card {
        background: rgba(15, 15, 25, 0.9);
        border: 2px solid #333;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none !important;
        display: block;
    }

    /* Efek Hover Khas Zettarig */
    .category-card:hover {
        border-color: #00ffff;
        transform: translateY(-5px);
        box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    }

    .category-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        transition: all 0.3s;
    }

    .category-card:hover .category-icon {
        text-shadow: 0 0 10px currentColor;
        transform: scale(1.1);
    }

    /* Garis Aksen Bawah sesuai Warna */
    .accent-line {
        height: 3px;
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
    }
</style>

<section class="py-5 bg-grid">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="pixel-font text-white mb-0 glitch-text" data-text="SELECT HARDWARE">SELECT HARDWARE</h2>
            <div class="mt-2" style="height: 2px; width: 100px; background: #ff00de; margin: 0 auto;"></div>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-md-4 col-sm-6">
    <a href="<?= base_url('produk/kategori/processor'); ?>" class="category-card p-4 text-center">
        <div class="category-icon text-info">
            <i class="fa-solid fa-microchip"></i>
        </div>
        <h5 class="pixel-font text-white mb-2" style="font-size: 0.8rem;">PROCESSOR</h5>
        <small class="text-muted d-block" style="font-family: 'VT323'; font-size: 1rem;">Main Processing Unit</small>
        <div class="accent-line bg-info"></div>
    </a>
</div>

<div class="col-md-4 col-sm-6">
    <a href="<?= base_url('produk/kategori/vga'); ?>" class="category-card p-4 text-center">
        <div class="category-icon text-warning">
            <i class="fa-solid fa-vr-cardboard"></i>
        </div>
        <h5 class="pixel-font text-white mb-2" style="font-size: 0.8rem;">VGA / GPU</h5>
        <small class="text-muted d-block" style="font-family: 'VT323'; font-size: 1rem;">Graphics Processing</small>
        <div class="accent-line bg-warning"></div>
    </a>
</div>

<div class="col-md-4 col-sm-6">
    <a href="<?= base_url('produk/kategori/ram'); ?>" class="category-card p-4 text-center">
        <div class="category-icon text-danger">
            <i class="fa-solid fa-memory"></i>
        </div>
        <h5 class="pixel-font text-white mb-2" style="font-size: 0.8rem;">MEMORY RAM</h5>
        <small class="text-muted d-block" style="font-family: 'VT323'; font-size: 1rem;">Random Access Memory</small>
        <div class="accent-line bg-danger"></div>
    </a>
</div>

        </div>
    </div>
</section>

<section class="bg-grid py-5 border-top border-dark">
    <div class="container">
        
        <div class="text-center mb-5">
            <div class="d-inline-block border border-2 border-danger px-3 py-1 mb-2 bg-dark">
                <span class="text-danger pixel-font" style="font-size: 0.8rem;">NEW ARRIVALS</span>
            </div>
            <h2 class="pixel-font text-white glitch-text" data-text="FRESH FROM INVENTORY">FRESH FROM INVENTORY</h2>
        </div>

        <div class="row g-4">
            <?php if (!empty($new_arrivals)): ?>
                <?php foreach ($new_arrivals as $item): ?>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        
                        <div class="pixel-product-card">
                            
                            <?php if ($item->stok > 0): ?>
                                <div class="pixel-badge bg-retro-success">READY STOCK</div>
                            <?php else: ?>
                                <div class="pixel-badge bg-retro-danger">SOLD OUT</div>
                            <?php endif; ?>

                            <div class="pixel-img-wrapper">
                                <img src="<?= !empty($item->gambar_produk) 
                                            ? base_url('assets/uploads/produk/'.$item->gambar_produk) 
                                            : base_url('assets/images/no-image.png'); ?>" 
                                     alt="<?= htmlspecialchars($item->nama_produk); ?>">
                            </div>

                            <div class="card-info">
                                <h5 class="product-title-retro text-uppercase">
                                    <?= htmlspecialchars(character_limiter($item->nama_produk, 30)); ?>
                                </h5>
                                
                                <span class="price-tag">
                                    Rp <?= number_format($item->harga_jual, 0, ',', '.'); ?>
                                </span>

                                <a href="<?= base_url('produk/detail/'.$item->slug_produk); ?>" 
                                   class="btn-pixel-block">
                                    > VIEW DETAIL_
                                </a>
                            </div>
                        </div>
                        </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <p class="pixel-font text-white">SYSTEM MESSAGE: [NO_DATA_FOUND]</p>
                    <small>Belum ada produk baru yang ditambahkan.</small>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<section class="container py-5">
    <div class="pixel-card bg-primary p-4 p-md-5 text-center position-relative overflow-hidden">
        <div style="position: absolute; top:0; left:0; width:100%; height:100%; opacity: 0.1; background: repeating-linear-gradient(45deg, #000, #000 10px, transparent 10px, transparent 20px);"></div>
        
        <div class="position-relative" style="z-index: 2;">
            <h2 class="pixel-font text-white mb-3">CUSTOM BUILD MISSION</h2>
            <p class="text-white mb-4 fs-5" style="font-family: 'VT323';">
                Bingung rakit PC? Biarkan expert kami yang mengerjakannya.<br>
                Mulai dari budget entry-level hingga sultan.
            </p>
            <a href="#" class="pixel-btn bg-white text-dark border-dark">
                <i class="fas fa-gamepad me-2"></i> START BUILDING
            </a>
        </div>
    </div>
</section>

<section class="container py-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="pixel-card bg-dark p-4">
                <div class="border-bottom border-secondary pb-2 mb-4">
                    <i class="fas fa-terminal text-success me-2"></i> <span class="text-success">root@zettarig:~/faq#</span> ./read_faq.exe
                </div>

                <div class="accordion accordion-flush" id="faqZetta">
                    
                    <div class="accordion-item bg-transparent border-0 mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-transparent text-white shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <span class="text-warning me-2">></span> Apakah barang bergaransi resmi?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqZetta">
                            <div class="accordion-body text-secondary pt-0 ps-4" style="font-family: 'VT323'; font-size: 1.1rem;">
                                Tentu saja. Semua komponen yang kami jual bersumber dari distributor resmi Indonesia (Astrindo, WPG, NJT, dll). Claim garansi bisa kami bantu.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent border-0 mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-transparent text-white shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <span class="text-warning me-2">></span> Berapa lama proses perakitan?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqZetta">
                            <div class="accordion-body text-secondary pt-0 ps-4" style="font-family: 'VT323'; font-size: 1.1rem;">
                                Untuk PC Standard: 1-2 hari kerja.<br>
                                Untuk PC Custom Watercooling: 3-5 hari kerja.<br>
                                Kami melakukan stress-test 1x24 jam sebelum dikirim.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>