<style>
    /* --- 1. KONTAINER BACKGROUND --- */
    .battle-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: radial-gradient(circle at bottom center, #1a0b2e 0%, #050510 70%); /* Gradasi langit */
        overflow: hidden;
    }

    /* --- 2. PARALLAX STARS (3 LAPIS) --- */
    .star-layer {
        position: absolute;
        width: 100%;
        height: 100%;
        background-repeat: repeat;
        top: 0; left: 0;
    }

    .stars-1 { /* Bintang Jauh (Lambat) */
        background-image: radial-gradient(white 1px, transparent 1px);
        background-size: 50px 50px;
        opacity: 0.3;
    }

    .stars-2 { /* Bintang Sedang */
        background-image: radial-gradient(white 2px, transparent 2px);
        background-size: 100px 100px;
        opacity: 0.5;
        animation: moveStars 100s linear infinite;
    }

    .stars-3 { /* Bintang Dekat (Cepat) */
        background-image: radial-gradient(#00ffff 1px, transparent 1px);
        background-size: 150px 150px;
        opacity: 0.8;
        animation: moveStars 50s linear infinite;
    }

    @keyframes moveStars {
        from { transform: translateY(0); }
        to { transform: translateY(1000px); }
    }

    /* --- 3. PLANET PIXEL --- */
    .retro-planet {
        position: absolute;
        top: 10%;
        right: 15%;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff00de 0%, #330033 100%);
        box-shadow: -5px -5px 0 rgba(255,255,255,0.1), 0 0 20px rgba(255, 0, 222, 0.4);
        opacity: 0.8;
    }
    .retro-moon {
        position: absolute;
        bottom: 20%;
        left: 10%;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #333;
        box-shadow: inset -5px -5px 0 #000;
        opacity: 0.6;
    }

    /* --- 4. KAPAL & LASER (Sama seperti sebelumnya, diperhalus) --- */
    .pixel-ship {
        position: absolute;
        width: 70px;
        filter: drop-shadow(0 0 8px currentColor);
    }

    .ship-cyan {
        color: #00ffff;
        top: 45%; left: -10%;
        animation: flyRight 8s linear infinite;
    }

    .ship-magenta {
        color: #ff00ff;
        top: 45%; right: -10%; /* Satu garis lurus sekarang */
        transform: scaleX(-1);
        animation: flyLeft 8s linear infinite;
    }

    .laser-beam {
        position: absolute;
        height: 4px;
        top: 48%; /* Center vertically with ships */
        width: 0;
        opacity: 0;
        box-shadow: 0 0 15px currentColor;
    }

    .laser-cyan {
        left: 40%;
        background: #00ffff; color: #00ffff;
        animation: fireRight 8s ease-out infinite;
    }

    .laser-magenta {
        right: 40%;
        background: #ff00ff; color: #ff00ff;
        animation: fireLeft 8s ease-out infinite;
    }

    /* --- 5. EFEK LEDAKAN (BARU) --- */
    .explosion {
        position: absolute;
        top: 46%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        background: white;
        border-radius: 50%;
        opacity: 0;
        z-index: 2;
    }

    .explosion-core {
        animation: explode 8s ease-out infinite;
    }

    @keyframes explode {
        0%, 38% { opacity: 0; transform: translate(-50%, -50%) scale(0); }
        39% { opacity: 1; transform: translate(-50%, -50%) scale(2); background: yellow; box-shadow: 0 0 20px orange; }
        42% { opacity: 0; transform: translate(-50%, -50%) scale(8); background: red; }
        100% { opacity: 0; }
    }

    /* KEYFRAMES KAPAL & LASER */
    @keyframes flyRight {
        0% { left: -15%; } 100% { left: 115%; }
    }
    @keyframes flyLeft {
        0% { right: -15%; } 100% { right: 115%; }
    }
    
    @keyframes fireRight {
        0%, 35% { width: 0; left: 35%; opacity: 0; }
        37% { width: 100px; opacity: 1; }
        40% { width: 15%; left: 42%; opacity: 0; } /* Hit center */
        100% { opacity: 0; }
    }
    @keyframes fireLeft {
        0%, 35% { width: 0; right: 35%; opacity: 0; }
        37% { width: 100px; opacity: 1; }
        40% { width: 15%; right: 42%; opacity: 0; } /* Hit center */
        100% { opacity: 0; }
    }

    /* --- 6. UI TWEAKS --- */
    .pixel-card-transparent {
        background-color: rgba(15, 15, 20, 0.85) !important;
        backdrop-filter: blur(5px);
        border: 2px solid #555;
        box-shadow: 0 0 30px rgba(0,0,0,0.8);
    }

    /* Glitch Effect untuk Judul LOGIN */
    .glitch-text {
        position: relative;
        color: #fff;
    }
    .glitch-text::before, .glitch-text::after {
        content: attr(data-text);
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
    }
    .glitch-text::before {
        left: 2px; text-shadow: -1px 0 #ff00de; clip: rect(24px, 550px, 90px, 0);
        animation: glitch-anim-2 3s infinite linear alternate-reverse;
    }
    .glitch-text::after {
        left: -2px; text-shadow: -1px 0 #00ffff; clip: rect(85px, 550px, 140px, 0);
        animation: glitch-anim 2.5s infinite linear alternate-reverse;
    }
    @keyframes glitch-anim {
        0% { clip: rect(10px, 9999px, 30px, 0); }
        20% { clip: rect(80px, 9999px, 100px, 0); }
        100% { clip: rect(40px, 9999px, 60px, 0); }
    }
    @keyframes glitch-anim-2 {
        0% { clip: rect(60px, 9999px, 80px, 0); }
        20% { clip: rect(10px, 9999px, 40px, 0); }
        100% { clip: rect(90px, 9999px, 110px, 0); }
    }
</style>

<div class="battle-background">
    <div class="star-layer stars-1"></div>
    <div class="star-layer stars-2"></div>
    <div class="star-layer stars-3"></div>

    <div class="retro-planet"></div>
    <div class="retro-moon"></div>

    <svg class="pixel-ship ship-cyan" viewBox="0 0 32 16" xmlns="http://www.w3.org/2000/svg">
        <path fill="#00ffff" d="M12 0 h10 v2 h-10 z M10 2 h14 v2 h-14 z M2 4 h24 v2 h-24 z M0 6 h28 v4 h-28 z M2 10 h24 v2 h-24 z M10 12 h14 v2 h-14 z M12 14 h10 v2 h-10 z"/>
    </svg>
    <div class="laser-beam laser-cyan"></div>

    <svg class="pixel-ship ship-magenta" viewBox="0 0 32 16" xmlns="http://www.w3.org/2000/svg">
        <path fill="#ff00ff" d="M12 0 h10 v2 h-10 z M10 2 h14 v2 h-14 z M2 4 h24 v2 h-24 z M0 6 h28 v4 h-28 z M2 10 h24 v2 h-24 z M10 12 h14 v2 h-14 z M12 14 h10 v2 h-10 z"/>
    </svg>
    <div class="laser-beam laser-magenta"></div>

    <div class="explosion explosion-core"></div>
</div>

<section class="container py-5" style="max-width:420px; position: relative; z-index: 1;">

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success rounded-0 border-2 border-success" style="background: rgba(0,0,0,0.8); color: #00ff00; font-family: 'VT323';">
      <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
    </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger rounded-0 border-2 border-danger" style="background: rgba(0,0,0,0.8); color: #ff5555; font-family: 'VT323';">
      <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <div class="card text-light pixel-card pixel-card-transparent p-4">
    <h3 class="pixel-font mb-4 text-center glitch-text" data-text="LOGIN SYSTEM">LOGIN SYSTEM</h3>

    <form action="<?= base_url('auth/login/process'); ?>" method="post">

      <div class="mb-3">
    <label style="font-family: 'VT323', monospace; font-size: 1.2rem; color: #00ffff;">USERNAME (CALLSIGN)</label>
    
    <input type="text" 
           name="username" 
           class="form-control rounded-0 bg-dark text-white border-secondary" 
           style="border-top: 2px solid #00ffff;" 
           placeholder="Ex: Maverick"
           required>
</div>

      <div class="mb-1">
        <label style="font-family: 'VT323', monospace; font-size: 1.2rem; color: #ff00de;">PASSCODE</label>
        <input type="password" name="password" class="form-control rounded-0 bg-dark text-white border-secondary" style="border-top: 2px solid #ff00de;" required>
      </div>

      <div class="text-end mb-4">
          <a href="<?= base_url('auth/forgot_password'); ?>" class="text-muted text-decoration-none" style="font-family: 'VT323'; font-size: 0.9rem;">
              Forgot Password?
          </a>
      </div>

      <button type="submit" class="pixel-btn w-100 mb-4" style="position:relative; overflow:hidden;">
        <i class="fas fa-rocket me-2"></i> LAUNCH
      </button>

      <p class="text-center mb-0" style="font-family: 'VT323';">
        New Recruit?
        <a href="<?= base_url('auth/register'); ?>" class="text-warning text-decoration-none border-bottom border-warning">Join the Force</a>
      </p>

    </form>
  </div>
</section>