<style>
    /* Transparansi kartu agar background animasi terlihat */
    .pixel-card-transparent {
        background-color: rgba(15, 15, 20, 0.85) !important;
        backdrop-filter: blur(5px);
        border: 2px solid #555;
        box-shadow: 0 0 30px rgba(0,0,0,0.8);
    }

    .glitch-text-green {
        position: relative;
        color: #00ff00;
        text-shadow: 2px 2px 0px #005500;
    }
</style>

<div class="battle-background">
    <div class="star-layer stars-1"></div>
    <div class="star-layer stars-2"></div>
    <div class="star-layer stars-3"></div>
    <div class="explosion explosion-core"></div>
</div>

<section class="container py-5" style="max-width:420px; position: relative; z-index: 1;">
    
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger rounded-0 border-2 border-danger" style="background: rgba(0,0,0,0.8); color: #ff5555;">
      <i class="fas fa-exclamation-triangle me-2"></i> <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <div class="card text-light pixel-card pixel-card-transparent p-4">
    <h3 class="pixel-font mb-4 text-center glitch-text-green" data-text="NEW ACCESS CODE">NEW ACCESS CODE</h3>
    
    <p class="text-center text-muted small mb-4" style="font-family:'VT323'; font-size:1.1rem;">
       Otoritas diverifikasi. Silakan masukkan kode akses baru untuk akun Anda.
    </p>

    <form action="<?= base_url('auth/process_change_password'); ?>" method="post">
      
      <div class="mb-3">
        <label style="font-family: 'VT323'; font-size: 1.2rem; color: #00ff00;">NEW PASSWORD</label>
        <input type="password" name="password" class="form-control rounded-0 bg-dark text-white border-secondary" style="border-top: 2px solid #00ff00;" required placeholder="********">
      </div>

      <div class="mb-4">
        <label style="font-family: 'VT323'; font-size: 1.2rem; color: #00ff00;">CONFIRM PASSWORD</label>
        <input type="password" name="conf_password" class="form-control rounded-0 bg-dark text-white border-secondary" style="border-top: 2px solid #00ff00;" required placeholder="********">
      </div>

      <button class="pixel-btn w-100" style="background-color: #00ff00; color: #000;">
        <i class="fas fa-save me-2"></i> UPDATE SYSTEM
      </button>

      <div class="mt-3 text-center">
        <small class="text-muted" style="font-family: 'Courier New'; font-size: 0.7rem;">ID: <?= $this->session->userdata('reset_email'); ?></small>
      </div>
    </form>
  </div>
</section>

<div class="crt-overlay"></div>