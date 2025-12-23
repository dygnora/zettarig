<section class="container py-5" style="max-width:420px; position: relative; z-index: 1;">

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
  <?php endif; ?>

  <div class="card text-light pixel-card pixel-card-transparent p-4">
    <h3 class="pixel-font mb-3 text-center text-warning">RECOVERY MODE</h3>
    <p class="text-center text-muted small mb-4" style="font-family:'VT323'; font-size:1.1rem;">
       Masukkan email untuk menerima sinyal reset password.
    </p>

    <form action="<?= base_url('auth/process_forgot'); ?>" method="post">
      <div class="mb-4">
        <label style="font-family: 'VT323'; font-size: 1.2rem; color: #00ffff;">REGISTERED EMAIL</label>
        <input type="email" name="email" class="form-control rounded-0 bg-dark text-white border-secondary" style="border-top: 2px solid #00ffff;" required>
      </div>

      <button class="pixel-btn w-100 bg-warning text-dark">
        <i class="fas fa-satellite-dish me-2"></i> SEND SIGNAL
      </button>

      <div class="text-center mt-3">
        <a href="<?= base_url('auth/login'); ?>" class="text-secondary text-decoration-none pixel-font" style="font-size:0.7rem;">
           < CANCEL MISSION
        </a>
      </div>
    </form>
  </div>
</section>