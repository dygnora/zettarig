<style>
    /* === FOOTER VARIABLES (Sesuai Navbar) === */
    :root {
        --footer-bg: #0f172a;       /* Dark Blue/Slate */
        --footer-border: #020617;   /* Almost Black */
        --pixel-accent: #fb923c;    /* Orange */
        --pixel-text: #e2e8f0;      /* White-ish */
        --pixel-dim: #64748b;       /* Grey */
    }

    /* === MARQUEE BAR (SYSTEM ALERT STYLE) === */
    .pixel-marquee {
        background: var(--pixel-accent);
        color: #000;
        border-top: 4px solid var(--footer-border);
        border-bottom: 4px solid var(--footer-border);
        padding: 8px 0;
        font-family: 'Press Start 2P', cursive; /* Font Judul */
        font-size: 0.6rem;
        overflow: hidden;
        white-space: nowrap;
    }
    .ticker-wrap { display: inline-block; animation: ticker 30s linear infinite; }
    .ticker-item { display: inline-block; padding: 0 2rem; }
    @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* === MAIN FOOTER CONTAINER === */
    .pixel-footer {
        background-color: var(--footer-bg);
        color: var(--pixel-text);
        padding-top: 3rem;
        border-bottom: 4px solid var(--footer-border); /* Penutup bawah */
        font-family: 'VT323', monospace; /* Font Isi */
        font-size: 1.3rem;
    }

    /* === HEADINGS === */
    .pixel-heading {
        font-family: 'Press Start 2P', cursive;
        font-size: 0.8rem;
        color: #fff;
        margin-bottom: 1.5rem;
        text-shadow: 3px 3px 0 #000; /* Efek 3D Teks */
        text-transform: uppercase;
        letter-spacing: -1px;
    }

    /* === LINKS (RPG MENU STYLE) === */
    .pixel-link {
        display: block;
        text-decoration: none;
        color: var(--pixel-dim);
        padding: 5px 0;
        transition: all 0.1s;
    }
    .pixel-link:hover {
        color: #fff;
        transform: translateX(5px); /* Geser kanan saat hover */
        text-shadow: 1px 1px 0 #000;
    }
    .pixel-link:hover::before {
        content: '>'; 
        color: var(--pixel-accent);
        margin-right: 5px;
    }

    /* === SOCIAL BUTTONS (GAMEPAD BUTTONS) === */
    .social-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        background: #1e3a8a; /* Warna Biru Navbar */
        border: 3px solid var(--footer-border);
        color: #fff;
        text-decoration: none;
        box-shadow: 4px 4px 0 #000; /* Hard Shadow */
        transition: all 0.1s;
        margin-right: 10px;
        font-size: 1.2rem;
    }
    .social-btn:hover {
        background: var(--pixel-accent);
        color: #000;
        transform: translate(2px, 2px); /* Efek tombol ditekan */
        box-shadow: 2px 2px 0 #000;
    }

    /* === NEWSLETTER INPUT === */
    .pixel-input-group {
        display: flex;
        border: 3px solid var(--footer-border);
        box-shadow: 4px 4px 0 #000;
        background: #000;
    }
    .pixel-input {
        flex: 1;
        background: #000;
        border: none;
        color: #fff;
        padding: 10px;
        font-family: 'VT323', monospace;
        font-size: 1.2rem;
        outline: none;
    }
    .pixel-submit {
        background: var(--pixel-dim);
        color: #fff;
        border: none;
        border-left: 3px solid var(--footer-border);
        padding: 0 15px;
        font-family: 'Press Start 2P';
        font-size: 0.6rem;
        cursor: pointer;
        transition: 0.1s;
    }
    .pixel-submit:hover {
        background: var(--pixel-accent);
        color: #000;
    }

    /* === COPYRIGHT BAR === */
    .pixel-copyright {
        background: #000;
        padding: 15px 0;
        text-align: center;
        font-family: 'VT323', monospace;
        color: var(--pixel-dim);
        font-size: 1.1rem;
        border-top: 4px solid var(--footer-border);
    }
</style>

<div class="pixel-marquee">
    <div class="ticker-wrap">
        <div class="ticker-item">*** SYSTEM ONLINE: WELCOME TO ZETTARIG ***</div>
        <div class="ticker-item">/// NEW QUEST: RAKIT PC IMPIAN SEKARANG ///</div>
        <div class="ticker-item">*** WARNING: STOK TERBATAS UNTUK RTX SERIES ***</div>
        <div class="ticker-item">/// JANGAN LUPA SAVE DATA ANDA (LOGIN) ///</div>
    </div>
</div>

<footer class="pixel-footer mt-auto">
    <div class="container">
        <div class="row gy-5">
            
            <div class="col-lg-5 col-md-12">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Z" style="width: 40px; height: 40px; border: 2px solid #fff; background:#000; padding:2px;">
                    <div class="pixel-heading mb-0" style="font-size: 1.2rem;">ZETTARIG</div>
                </div>
                <p class="pe-lg-5 text-secondary">
                    Platform rakit PC dengan gaya retro masa depan. Kami menyediakan hardware terbaik untuk menunjang performa gaming Anda.
                </p>
                <div class="mt-4 font-monospace text-warning">
                    <i class="fas fa-signal"></i> SERVER STATUS: <span class="text-success">ONLINE</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <div class="pixel-heading">SHORTCUTS</div>
                <nav class="d-flex flex-column">
                    <a href="<?= base_url('produk') ?>" class="pixel-link">ITEM SHOP</a>
                    <a href="<?= base_url('rakit') ?>" class="pixel-link">BUILD PC</a>
                    <a href="<?= base_url('about') ?>" class="pixel-link">SYSTEM INFO</a>
                    <a href="<?= base_url('akun') ?>" class="pixel-link">PLAYER PROFILE</a>
                </nav>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="pixel-heading">CONNECT</div>
                
                <div class="mb-4">
                    <a href="#" class="social-btn" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn" title="Discord"><i class="fab fa-discord"></i></a>
                    <a href="#" class="social-btn" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>

                <div class="pixel-heading" style="font-size: 0.6rem; margin-bottom: 10px;">NEWSLETTER</div>
                <form action="<?= base_url('subscribe') ?>" method="post">
                    <div class="pixel-input-group">
                        <input type="email" class="pixel-input" placeholder="Enter Email...">
                        <button type="button" class="pixel-submit">JOIN</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</footer>

<div class="pixel-copyright">
    &copy; <?= date('Y'); ?> ZETTARIG CORP. ALL RIGHTS RESERVED.
    <br>
    <span style="font-size: 0.9rem; color: #334155;">POWERED BY CODEIGNITER 3</span>
</div>