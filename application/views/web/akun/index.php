<?php
/**
 * ==========================================================
 * DASHBOARD CUSTOMER - ZETTARIG
 * ==========================================================
 * - Info akun
 * - Navigasi pesanan
 * - Pixel style
 */
?>

<!-- ======================================================
     HEADER
====================================================== -->
<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-2">AKUN SAYA</h1>
    <p class="text-muted mb-0">
      Selamat datang, <?= htmlspecialchars($customer->nama); ?>
    </p>
  </div>
</section>

<!-- ======================================================
     CONTENT
====================================================== -->
<section class="container py-5">

  <div class="row g-4">

    <!-- INFO AKUN -->
    <div class="col-md-6">
      <div class="card bg-dark text-light pixel-card p-4 h-100">

        <h5 class="mb-3">Informasi Akun</h5>

        <p class="mb-1"><strong>Nama</strong></p>
        <p class="text-muted"><?= htmlspecialchars($customer->nama); ?></p>

        <p class="mb-1"><strong>Email</strong></p>
        <p class="text-muted"><?= htmlspecialchars($customer->email); ?></p>

        <p class="mb-1"><strong>No. HP</strong></p>
        <p class="text-muted"><?= htmlspecialchars($customer->no_hp); ?></p>

        <p class="mb-1"><strong>Alamat</strong></p>
        <p class="text-muted"><?= nl2br(htmlspecialchars($customer->alamat)); ?></p>

      </div>
    </div>

    <!-- MENU -->
    <div class="col-md-6">
      <div class="card bg-dark text-light pixel-card p-4 h-100">

        <h5 class="mb-4">Menu</h5>

        <a href="<?= base_url('akun/pesanan'); ?>" class="pixel-btn mb-3 w-100">
        RIWAYAT PESANAN
        </a>


        <a href="<?= base_url('akun/logout'); ?>"
           class="btn btn-outline-danger w-100"
           onclick="return confirm('Logout dari akun?')">
          LOGOUT
        </a>

      </div>
    </div>

  </div>

</section>
