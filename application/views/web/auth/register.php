<style>
    /* --- RESET & BASE --- */
    body { background-color: #050510; }

    /* --- FIX POSISI PESAWAT AGAR TIDAK PECAH --- */
    .pixel-ship-fixed {
        position: absolute;
        width: 80px; /* Ukuran dikunci agar tidak memenuhi layar */
        height: auto;
        z-index: 0;
        image-rendering: pixelated;
        filter: drop-shadow(0 0 10px currentColor);
    }

    .ship-cyan { color: #00ffff; top: 20%; left: -100px; animation: flyRight 10s linear infinite; }
    .ship-magenta { color: #ff00de; top: 70%; right: -100px; transform: scaleX(-1); animation: flyLeft 12s linear infinite; }

    @keyframes flyRight { from { left: -100px; } to { left: 110%; } }
    @keyframes flyLeft { from { right: -100px; } to { right: 110%; } }

    /* --- FORM STYLING --- */
    .pixel-card-register {
        background-color: rgba(15, 15, 25, 0.9);
        backdrop-filter: blur(10px);
        border: 2px solid #333;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    .reg-label {
        font-family: 'VT323', monospace;
        font-size: 1.1rem;
        margin-bottom: 4px;
        display: block;
    }

    .form-control-pixel {
        background-color: #080815 !important;
        border: 1px solid #444 !important;
        border-radius: 0 !important;
        color: white !important;
        font-family: 'Courier New', monospace;
    }

    .form-control-pixel:focus {
        border-color: #00ffff !important;
        box-shadow: 0 0 8px rgba(0, 255, 255, 0.3);
    }
</style>

<div class="battle-background" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1; overflow:hidden;">
    <div class="star-layer stars-1"></div>
    <div class="star-layer stars-2"></div>
    
    <svg class="pixel-ship-fixed ship-cyan" viewBox="0 0 32 16" fill="currentColor">
        <path d="M12 0h8v2h-8zM8 2h16v2H8zM4 4h24v4H4zM0 8h32v4H0zM4 12h4v2H4zM12 12h8v2h-8zM24 12h4v2h-4z"/>
    </svg>

    <svg class="pixel-ship-fixed ship-magenta" viewBox="0 0 32 16" fill="currentColor">
        <path d="M12 0h10v2h-10zM10 2h14v2h-14zM2 4h24v2h-24zM0 6h28v4h-28zM2 10h24v2h-24zM10 12h14v2h-14zM12 14h10v2h-10z"/>
    </svg>
</div>

<section class="container py-5" style="max-width:550px; position: relative; z-index: 10;">
    
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger rounded-0 border-2 border-danger bg-dark text-danger mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card pixel-card-register p-4">
        <h3 class="pixel-font mb-4 text-center glitch-text" data-text="NEW RECRUIT" style="color:#fff;">NEW RECRUIT</h3>

        <form action="<?= base_url('auth/process_register'); ?>" method="post">
            <div class="row g-3">
                <div class="col-12">
                    <label class="reg-label text-info">FULL NAME (IDENTIFIER)</label>
                    <input type="text" name="nama" class="form-control form-control-pixel" style="border-left: 4px solid #00ffff !important;" required>
                </div>

                <div class="col-12">
                    <label class="reg-label text-primary" style="color: #4da3ff !important;">USERNAME (CALLSIGN)</label>
                    <input type="text" name="username" class="form-control form-control-pixel" style="border-left: 4px solid #4da3ff !important;" required>
                </div>

                <div class="col-md-6">
                    <label class="reg-label text-warning">EMAIL ADDR</label>
                    <input type="email" name="email" class="form-control form-control-pixel" style="border-left: 4px solid #ffc107 !important;" required>
                </div>

                <div class="col-md-6">
                    <label class="reg-label text-warning">PASSCODE</label>
                    <input type="password" name="password" class="form-control form-control-pixel" style="border-left: 4px solid #ffc107 !important;" required>
                </div>

                <div class="col-12">
                    <label class="reg-label text-danger">COMMS NUMBER (HP)</label>
                    <input type="text" name="no_hp" class="form-control form-control-pixel" style="border-left: 4px solid #dc3545 !important;" required>
                </div>

                <div class="col-12">
                    <label class="reg-label text-success">BASE SECTOR (ADDRESS)</label>
                    <textarea name="alamat" class="form-control form-control-pixel" rows="2" style="border-left: 4px solid #198754 !important;" required></textarea>
                </div>
            </div>

            <button type="submit" class="pixel-btn w-100 mt-4 py-3" style="font-size: 1rem;">
                <i class="fas fa-user-plus me-2"></i> INITIALIZE REGISTRATION
            </button>

            <div class="text-center mt-4">
                <p class="text-secondary small mb-0" style="font-family:'VT323';">
                    Already part of the force? 
                    <a href="<?= base_url('auth/login'); ?>" class="text-info text-decoration-none border-bottom border-info">ACCESS TERMINAL</a>
                </p>
            </div>
        </form>
    </div>
</section>

<div class="crt-overlay" style="position:fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index:100; background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%), linear-gradient(90deg, rgba(255, 0, 0, 0.03), rgba(0, 255, 0, 0.01), rgba(0, 0, 255, 0.03)); background-size: 100% 3px, 3px 100%;"></div>