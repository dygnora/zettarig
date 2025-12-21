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
                    <a href="<?= base_url('rakit'); ?>"
                       class="pixel-btn bg-dark text-white border-white fs-5">
                        <i class="fas fa-tools me-2"></i> RAKIT PC
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

<section class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <small class="text-uppercase text-muted fw-bold">Select Category</small>
            <h2 class="pixel-font">HARDWARE</h2>
        </div>
        <a href="<?= base_url('produk'); ?>" class="text-decoration-none text-white hover-underline">
            View All <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="row g-3">
        <?php 
        $cats = [
            ['Processor', 'cpu', 'bg-primary'],
            ['VGA Card', 'tv', 'bg-danger'],
            ['Motherboard', 'chess-board', 'bg-success'],
            ['RAM', 'memory', 'bg-warning'],
            ['Storage', 'hdd', 'bg-info'],
            ['Casing', 'box', 'bg-secondary']
        ];
        foreach ($cats as $c): ?>
        <div class="col-6 col-md-2">
            <a href="<?= base_url('produk?kategori='.strtolower($c[0])); ?>" class="text-decoration-none">
                <div class="pixel-card p-3 text-center h-100 hover-up bg-dark">
                    <div class="mb-2 rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: rgba(255,255,255,0.1);">
                        <i class="fas fa-<?= $c[1]; ?> fs-4 text-white"></i>
                    </div>
                    <h6 class="pixel-font text-white mb-0" style="font-size: 0.7rem;"><?= $c[0]; ?></h6>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="bg-grid py-5 border-top border-dark">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-danger pixel-font p-2 mb-2">NEW ARRIVALS</span>
            <h2 class="pixel-font">FRESH FROM INVENTORY</h2>
        </div>

        <div class="row g-4">
            <?php 
            // Simulasi Data (Nanti diganti $featured)
            for ($i = 1; $i <= 4; $i++): 
            ?>
            <div class="col-md-3 col-6">
                <div class="card pixel-card h-100 border-0 bg-dark text-white position-relative">
                    
                    <div class="position-absolute top-0 start-0 bg-success px-2 py-1 m-2 border border-dark" style="z-index: 2; font-size: 0.7rem;">
                        READY STOCK
                    </div>

                    <div class="p-3 bg-white d-flex align-items-center justify-content-center" style="height: 180px; border-bottom: 4px solid #000;">
                        <img src="https://dummyimage.com/300x300/eee/000&text=GPU+RTX+4060" class="img-fluid" alt="Produk">
                    </div>
                    
                    <div class="card-body p-3 d-flex flex-column">
                        <small class="text-muted mb-1">VGA Card</small>
                        <h5 class="card-title pixel-font fs-6 mb-3 text-truncate">GeForce RTX 4060 Ti 8GB</h5>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-info" style="font-family: 'VT323'; font-size: 1.4rem;">Rp 6.500.000</span>
                            </div>
                            <button class="pixel-btn w-100 py-2">
                                + ADD TO CART
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
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