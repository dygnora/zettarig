<?php
$session_user = $this->session->userdata('customer_nama');

if ($session_user) {
    $display_user = strtoupper(str_replace(' ', '_', $session_user)); 
} else {
    $display_user = 'GUEST';
}
?>

<style>
    :root {
        --retro-bg: #050505;
        --retro-green: #0f0;
        --retro-pink: #ff00c1;
        --retro-cyan: #00fff9;
        --retro-orange: #ffaa00;
        --scanline-color: rgba(18, 16, 16, 0.5);
    }

    .font-pixel { font-family: 'Press Start 2P', cursive; line-height: 1.5; }
    .font-term { font-family: 'VT323', monospace; }
    
    .cyber-grid {
        position: absolute; width: 200%; height: 200%; top: -50%; left: -50%;
        background-image: 
            linear-gradient(rgba(0, 255, 249, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 255, 249, 0.1) 1px, transparent 1px);
        background-size: 40px 40px;
        transform: perspective(500px) rotateX(60deg);
        animation: grid-move 20s linear infinite;
        z-index: 0;
        pointer-events: none;
    }
    @keyframes grid-move { 0% { transform: perspective(500px) rotateX(60deg) translateY(0); } 100% { transform: perspective(500px) rotateX(60deg) translateY(40px); } }

    .retro-window {
        background: #111;
        border: 4px solid #444;
        box-shadow: 
            -4px -4px 0 #222, 
            4px 4px 0 #000,
            8px 8px 0 rgba(0,0,0,0.5);
        position: relative;
        overflow: hidden;
    }
    .window-bar {
        background: linear-gradient(90deg, #000080, #108de0);
        padding: 5px 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #444;
    }
    .window-title { color: white; font-family: 'VT323'; font-size: 1.2rem; letter-spacing: 1px; font-weight: bold; text-transform: uppercase; }
    .window-controls span { display: inline-block; width: 12px; height: 12px; border: 1px solid white; background: #ccc; box-shadow: inset -1px -1px 0 #000; }

    .glitch-text { position: relative; color: white; mix-blend-mode: lighten; }
    .glitch-text:hover { animation: glitch-skew 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite; color: var(--retro-pink); }
    @keyframes glitch-skew { 0% { transform: skew(0deg); } 20% { transform: skew(-2deg); } 40% { transform: skew(2deg); } 60% { transform: skew(-1deg); } 80% { transform: skew(1deg); } 100% { transform: skew(0deg); } }

    .crt-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.25) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.06), rgba(0, 255, 0, 0.02), rgba(0, 0, 255, 0.06));
        background-size: 100% 2px, 3px 100%;
        pointer-events: none; z-index: 9999;
    }

    .stats-card { transition: transform 0.2s, box-shadow 0.2s; border: 2px solid #333; background: #0a0a0a; }
    .stats-card:hover { transform: translateY(-5px); border-color: var(--retro-green); box-shadow: 0 0 15px var(--retro-green); }
    .stats-card:hover i { color: var(--retro-green) !important; text-shadow: 0 0 10px var(--retro-green); }

    .typing-cursor::after { content: '█'; animation: cursor-blink 1s infinite; color: var(--retro-green); margin-left: 2px; }
    @keyframes cursor-blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
</style>

<div class="crt-overlay"></div>

<section class="position-relative d-flex align-items-center justify-content-center overflow-hidden" style="min-height: 80vh; background-color: var(--retro-bg);">
    <div class="cyber-grid"></div>
    <div class="position-absolute top-0 w-100 h-100 bg-gradient-to-b from-transparent to-black" style="background: radial-gradient(circle, transparent 20%, #050505 90%);"></div>

    <div class="container position-relative text-center z-2">
        <div class="mb-4">
            <span class="badge bg-black border border-success text-success font-term p-2" style="font-size: 1.2rem;">
                <i class="fas fa-microchip me-2"></i> SYSTEM_READY
            </span>
        </div>
        
        <h1 class="display-1 font-pixel text-white mb-2 glitch-text" style="text-shadow: 4px 4px 0 #000080;">
            ZETTARIG
        </h1>
        <h2 class="h4 font-pixel text-secondary mb-5" style="font-size: 0.8rem; letter-spacing: 4px;">
            // HIGH_PERFORMANCE_ARCHITECTS
        </h2>

        <div class="retro-window mx-auto text-start" style="max-width: 700px;">
            <div class="window-bar">
                <div class="window-title">COMMAND.EXE</div>
                <div class="window-controls"><span></span> <span></span></div>
            </div>
            <div class="p-4 bg-black">
                <p class="font-term text-success mb-0" style="font-size: 1.4rem; line-height: 1.4;">
                    <span class="text-secondary">C:\Users\<?= $display_user ?>&gt;</span> 
                    <span id="typing-text"></span><span class="typing-cursor"></span>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-black border-top border-secondary position-relative">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="stats-card p-4 text-center h-100 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-2 font-pixel text-muted" style="font-size: 0.5rem;">DB_ID: #01</div>
                    <i class="fas fa-hdd fa-3x text-secondary mb-3 transition-all"></i>
                    <h3 class="font-pixel text-white counter" data-target="1500">0</h3>
                    <p class="font-term text-success fs-5 mb-0">COMPONENTS INSTALLED</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card p-4 text-center h-100 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-2 font-pixel text-muted" style="font-size: 0.5rem;">NET_ID: #02</div>
                    <i class="fas fa-user-astronaut fa-3x text-secondary mb-3 transition-all"></i>
                    <h3 class="font-pixel text-white counter" data-target="850">0</h3>
                    <p class="font-term text-warning fs-5 mb-0">ACTIVE USERS</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card p-4 text-center h-100 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 p-2 font-pixel text-muted" style="font-size: 0.5rem;">SAT_ID: #03</div>
                    <i class="fas fa-check-double fa-3x text-secondary mb-3 transition-all"></i>
                    <h3 class="font-pixel text-white counter" data-target="100">0</h3>
                    <p class="font-term text-info fs-5 mb-0">SATISFACTION %</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 position-relative" style="background-color: #080808;">
    <div class="container">
        <div class="retro-window">
            <div class="window-bar" style="background: linear-gradient(90deg, #800000, #e01010);">
                <div class="window-title">QUEST_LOG.TXT</div>
                <div class="window-controls"><span></span></div>
            </div>
            <div class="row g-0">
                <div class="col-lg-7 bg-black p-5 border-end border-secondary">
                    <h3 class="font-pixel text-white mb-4" style="font-size: 1.2rem; color: #ff5f5f;">
                        <i class="fas fa-scroll me-2"></i> MAIN_OBJECTIVE
                    </h3>
                    <p class="font-term text-white-50 fs-4 mb-4">
                        "Membangun ekosistem hardware paling terpercaya di Indonesia. Menghapus keraguan antara barang asli dan palsu."
                    </p>
                    <div class="d-flex gap-3">
                        <div class="border border-secondary p-2 text-center" style="min-width: 100px;">
                            <small class="font-pixel text-muted d-block" style="font-size: 0.5rem;">REWARD</small>
                            <span class="font-term text-warning fs-5">TRUST++</span>
                        </div>
                        <div class="border border-secondary p-2 text-center" style="min-width: 100px;">
                            <small class="font-pixel text-muted d-block" style="font-size: 0.5rem;">DIFFICULTY</small>
                            <span class="font-term text-danger fs-5">HARDCORE</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 bg-dark p-5">
                    <h3 class="font-pixel text-white mb-4" style="font-size: 1rem;">> EXECUTION_PLAN</h3>
                    
                    <div class="d-flex align-items-center mb-3">
                        <i class="far fa-check-square text-success me-3 fa-lg"></i>
                        <div>
                            <h6 class="font-pixel text-white mb-0" style="font-size: 0.7rem;">ORIGINALITY_CHECK</h6>
                            <small class="font-term text-muted fs-5">Garansi resmi 100%</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="far fa-check-square text-success me-3 fa-lg"></i>
                        <div>
                            <h6 class="font-pixel text-white mb-0" style="font-size: 0.7rem;">SPEED_OPTIMIZATION</h6>
                            <small class="font-term text-muted fs-5">Rakit & Kirim < 24 Jam</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <i class="far fa-square text-secondary me-3 fa-lg"></i>
                        <div>
                            <h6 class="font-pixel text-white mb-0" style="font-size: 0.7rem;">WORLD_DOMINATION</h6>
                            <small class="font-term text-muted fs-5">Loading...</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const textToType = "Zettarig adalah platform manajemen penjualan dan perakitan PC yang dirancang untuk mengelola seluruh proses hardware secara terintegrasi. Mulai dari katalog produk, hingga transaksi dan pembayaran, semuanya dikendalikan dalam satu sistem.";
    const typingElement = document.getElementById('typing-text');
    let charIndex = 0;

    function typeWriter() {
        if (charIndex < textToType.length) {
            typingElement.innerHTML += textToType.charAt(charIndex);
            charIndex++;
            setTimeout(typeWriter, 50);
        }
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                typeWriter();
                observer.unobserve(entry.target);
            }
        });
    });
    observer.observe(document.querySelector('.retro-window'));

    const counters = document.querySelectorAll('.counter');
    const speed = 100;

    const animateCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    };

    let hasAnimated = false;
    window.addEventListener('scroll', () => {
        const statsSection = document.querySelector('.counter');
        if(statsSection) {
            const position = statsSection.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            if(position < screenPosition && !hasAnimated) {
                animateCounters();
                hasAnimated = true;
            }
        }
    });
});
</script>