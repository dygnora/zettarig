<style>
    /* === VARIABLES === */
    :root {
        --footer-bg: #020617;     /* Dark Slate */
        --neon-blue: #38bdf8;     /* Cyan */
        --neon-orange: #fb923c;   /* Orange */
        --neon-green: #22c55e;    /* Terminal Green */
        --text-dim: #94a3b8;      /* Dimmed Text */
    }

    /* === FONTS === */
    .font-pixel { font-family: 'Press Start 2P', cursive; }
    .font-term { font-family: 'VT323', monospace; }

    /* === MARQUEE BAR === */
    .system-msg {
        background: #000;
        color: var(--neon-green);
        border-bottom: 2px solid #222;
        padding: 8px 0;
        font-family: 'VT323', monospace;
        font-size: 1.1rem;
        overflow: hidden;
        white-space: nowrap;
    }
    .ticker-wrap { display: inline-block; animation: ticker 25s linear infinite; }
    .ticker-item { display: inline-block; padding: 0 3rem; }
    @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* === MAIN FOOTER === */
    .terminal-footer {
        background-color: var(--footer-bg);
        border-top: 4px solid var(--neon-blue); /* Garis Neon Tebal */
        color: var(--text-dim);
        font-family: 'VT323', monospace;
        font-size: 1.2rem;
        padding-top: 4rem;
        padding-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Efek Grid Background Halus */
    .terminal-footer::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-image: 
            linear-gradient(rgba(56, 189, 248, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(56, 189, 248, 0.05) 1px, transparent 1px);
        background-size: 20px 20px;
        pointer-events: none;
        z-index: 0;
    }

    /* === HEADINGS === */
    .footer-heading {
        font-family: 'Press Start 2P', cursive;
        font-size: 0.85rem; /* Ukuran pas untuk pixel font */
        color: #fff;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        display: flex; align-items: center; gap: 10px;
        text-shadow: 2px 2px 0px #000;
    }

    /* === LINKS & COMMANDS === */
    .cmd-link {
        display: block;
        text-decoration: none;
        color: var(--text-dim);
        padding: 6px 0;
        font-family: 'VT323', monospace; /* Lebih mudah dibaca dibanding pixel font */
        font-size: 1.3rem;
        transition: 0.3s;
        border-left: 2px solid transparent;
    }
    .cmd-link:hover {
        color: var(--neon-orange);
        padding-left: 15px;
        border-left: 2px solid var(--neon-orange);
        background: linear-gradient(90deg, rgba(251, 146, 60, 0.1), transparent);
    }

    /* === SOCIAL ICONS (DATA PORTS) === */
    .social-grid {
        display: flex; gap: 10px; margin-bottom: 1.5rem;
    }
    .data-port {
        width: 45px; height: 45px;
        background: #0f172a;
        border: 2px solid #334155;
        color: var(--text-dim);
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 1.2rem;
    }
    .data-port:hover {
        border-color: var(--neon-blue);
        color: var(--neon-blue);
        box-shadow: 0 0 10px var(--neon-blue);
        transform: translateY(-3px);
    }

    /* === NEWSLETTER INPUT === */
    .terminal-input-group {
        display: flex;
        border: 2px solid #334155;
        background: #000;
    }
    .terminal-input-group:focus-within {
        border-color: var(--neon-green);
    }
    .term-prompt {
        background: #000; color: var(--neon-green);
        padding: 10px; font-family: 'Press Start 2P'; font-size: 0.7rem;
        display: flex; align-items: center;
    }
    .term-field {
        background: transparent; border: none; color: #fff;
        width: 100%; padding: 10px;
        font-family: 'VT323'; font-size: 1.2rem;
        outline: none;
    }
    .term-btn {
        background: #334155; color: #fff; border: none;
        padding: 0 20px; font-family: 'Press Start 2P'; font-size: 0.6rem;
        cursor: pointer; transition: 0.3s;
    }
    .term-btn:hover { background: var(--neon-green); color: #000; }

    /* === COPYRIGHT BAR === */
    .status-bar {
        background: #000;
        border-top: 1px solid #333;
        padding: 15px 0;
        font-family: 'Press Start 2P';
        font-size: 0.6rem;
        color: #64748b;
        text-align: center;
    }
</style>

<div class="system-msg">
    <div class="ticker-wrap">
        <div class="ticker-item">*** SYSTEM ALERT: ZETTARIG CORE ONLINE ***</div>
        <div class="ticker-item">/// NEW ARRIVAL: RTX 5090 [IN STOCK] ///</div>
        <div class="ticker-item">*** SAVE YOUR GAME BEFORE SHUTDOWN ***</div>
        <div class="ticker-item">/// CONTACT ADMIN FOR CUSTOM BUILD ///</div>
    </div>
</div>

<footer class="terminal-footer mt-auto">
    <div class="container position-relative" style="z-index: 1;">
        <div class="row gy-5"> <div class="col-lg-5 col-md-12">
                <div class="footer-heading">
                    <i class="fas fa-microchip" style="color: var(--neon-blue);"></i>
                    ZETTARIG_SYSTEMS
                </div>
                <p class="mb-4 pe-lg-5" style="line-height: 1.6;">
                    Merakit bukan sekadar memasang komponen. Ini adalah seni membangun <strong class="text-white">mesin tempur digital</strong> Anda.
                </p>
                <div class="d-flex align-items-center gap-2 font-term">
                    <span style="color: var(--neon-green);">●</span> 
                    SERVER STATUS: <span class="text-white">ONLINE (PING: 2ms)</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <div class="footer-heading">SYSTEM_CMDS</div>
                <nav class="d-flex flex-column">
                    <a href="<?= base_url('shop') ?>" class="cmd-link">> INITIATE_SHOP</a>
                    <a href="<?= base_url('rakit') ?>" class="cmd-link">> START_BUILD.EXE</a>
                    <a href="<?= base_url('about') ?>" class="cmd-link">> VIEW_LOGS (About)</a>
                    <a href="<?= base_url('support') ?>" class="cmd-link">> HELP_CENTER</a>
                </nav>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="footer-heading">DATA_PORTS</div>
                <p class="mb-3">Hubungkan ke jaringan neural kami:</p>
                
                <div class="social-grid">
                    <a href="#" class="data-port" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="data-port" title="Discord"><i class="fab fa-discord"></i></a>
                    <a href="#" class="data-port" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="data-port" title="GitHub"><i class="fab fa-github"></i></a>
                </div>

                <p class="mb-2 mt-4" style="font-size: 1rem;">Subscribe Update:</p>
                <form action="<?= base_url('subscribe') ?>" method="post">
                    <div class="terminal-input-group">
                        <div class="term-prompt">></div>
                        <input