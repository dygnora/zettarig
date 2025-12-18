<section class="container py-5" style="max-width:420px;">

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
      <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <div class="card bg-dark text-light pixel-card p-4">
    <h3 class="pixel-font mb-4 text-center">LOGIN</h3>

    <form action="<?= base_url('auth/login/process'); ?>" method="post">

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button class="pixel-btn w-100">LOGIN</button>

      <p class="text-center mt-3 mb-0">
        Belum punya akun?
        <a href="<?= base_url('auth/register'); ?>">Daftar</a>
      </p>

    </form>
  </div>

</section>
