<section class="container py-5" style="max-width:520px;">

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
      <?= $this->session->flashdata('error'); ?>
    </div>
  <?php endif; ?>

  <div class="card bg-dark text-light pixel-card p-4">
    <h3 class="pixel-font mb-4 text-center">REGISTER</h3>

    <form action="<?= base_url('auth/register/process'); ?>" method="post">

      <div class="mb-3">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>No. HP</label>
        <input type="text" name="no_hp" class="form-control" required>
      </div>

      <div class="mb-4">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" rows="3" required></textarea>
      </div>

      <button class="pixel-btn w-100">DAFTAR</button>

      <p class="text-center mt-3 mb-0">
        Sudah punya akun?
        <a href="<?= base_url('auth/login'); ?>">Login</a>
      </p>

    </form>
  </div>

</section>
