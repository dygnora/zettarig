<?php
/**
 * ==========================================================
 * ABOUT PAGE - ZETTARIG
 * ==========================================================
 * Style:
 * - Konsisten dengan Home
 * - bg-grid, pixel-font, pixel-card
 */
?>

<!-- ======================================================
     HEADER
====================================================== -->
<section class="py-5 bg-grid">
  <div class="container text-center">
    <h1 class="pixel-font mb-3">TENTANG ZETTARIG</h1>
    <p class="text-muted mb-0">
      Platform hardware modern untuk kebutuhan gaming & workstation
    </p>
  </div>
</section>

<!-- ======================================================
     CONTENT
====================================================== -->
<section class="container py-5">

  <div class="row g-4">

    <!-- DESKRIPSI -->
    <div class="col-md-6">
      <div class="card bg-dark text-light pixel-card p-4 h-100">

        <h5 class="mb-3">Apa itu Zettarig?</h5>

        <p class="text-muted mb-3">
          <strong>Zettarig</strong> adalah platform penjualan hardware komputer
          yang berfokus pada komponen berkualitas tinggi seperti GPU, CPU,
          RAM, dan perangkat pendukung lainnya.
        </p>

        <p class="text-muted mb-0">
          Kami menghadirkan sistem terintegrasi mulai dari manajemen produk,
          transaksi, hingga pelacakan pesanan secara real-time untuk customer.
        </p>

      </div>
    </div>

    <!-- VISI MISI -->
    <div class="col-md-6">
      <div class="card bg-dark text-light pixel-card p-4 h-100">

        <h5 class="mb-3">Visi & Misi</h5>

        <p class="mb-1"><strong>Visi</strong></p>
        <p class="text-muted mb-3">
          Menjadi platform hardware terpercaya dengan sistem modern dan transparan.
        </p>

        <p class="mb-1"><strong>Misi</strong></p>
        <ul class="text-muted mb-0">
          <li>Menyediakan produk hardware berkualitas</li>
          <li>Memberikan pengalaman belanja yang aman & mudah</li>
          <li>Menghadirkan sistem transaksi yang transparan</li>
        </ul>

      </div>
    </div>

  </div>

  <!-- FOOTER INFO -->
  <div class="text-center mt-5 text-muted">
    <p class="mb-1">© <?= date('Y'); ?> Zettarig</p>
    <small>Built with CodeIgniter & Bootstrap</small>
  </div>

</section>
