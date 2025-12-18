<?php
/**
 * ==========================================================
 * HOME PAGE - ZETTARIG (BOOTSTRAP-FIRST, CLEAN)
 * ==========================================================
 * Prinsip:
 * - Layout & spacing: Bootstrap utility
 * - Visual pixel: theme.css (pixel-font, pixel-card, pixel-btn)
 * - Gridline: bg-grid
 * - Tanpa section tidak perlu (partner & rekomendasi dihapus)
 */
?>

<!-- ======================================================
     HERO SECTION (FULL SCREEN / STATIC)
====================================================== -->
<section class="hero-full bg-grid d-flex align-items-center text-center min-vh-100">

  <div class="container">

    <h1 class="pixel-font hero-title mb-4">
      GPU & CPU<br>
      GENERASI<br>
      TERBARU
    </h1>

    <p class="hero-subtitle mx-auto mb-5" style="max-width:620px;">
      Update hardware terbaru untuk gaming, content creation,
      dan workstation dengan performa maksimal.
    </p>

    <a href="<?= base_url('produk'); ?>" class="pixel-btn">
      CEK KATALOG
    </a>

  </div>

</section>

<!-- ======================================================
     SERVICE HIGHLIGHTS (TRUST BUILDING)
====================================================== -->
<section class="container py-5 bg-grid">
  <div class="row g-4 text-center">

    <div class="col-md-3">
      <div class="card bg-dark text-light p-4 pixel-card h-100">
        <h5>🛠️ Rakit Gratis</h5>
        <p class="mb-0">Perakitan rapi oleh teknisi berpengalaman.</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-light p-4 pixel-card h-100">
        <h5>🛡️ Garansi Resmi</h5>
        <p class="mb-0">Produk original bergaransi distributor.</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-light p-4 pixel-card h-100">
        <h5>🚚 Pengiriman Aman</h5>
        <p class="mb-0">Packing aman untuk hardware sensitif.</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark text-light p-4 pixel-card h-100">
        <h5>💬 Konsultasi</h5>
        <p class="mb-0">Bantu pilih spesifikasi sesuai kebutuhan.</p>
      </div>
    </div>

  </div>
</section>

<!-- ======================================================
     KATEGORI POPULER (FOKUS 3)
====================================================== -->
<section class="container py-5 bg-grid">
  <h2 class="pixel-font text-center mb-4">KATEGORI POPULER</h2>

  <div class="row g-4 text-center">
    <?php foreach (['VGA', 'RAM', 'CPU'] as $k): ?>
      <div class="col-6 col-md-4">
        <div class="card bg-dark text-light p-4 pixel-card">
          <h5 class="pixel-font mb-0"><?= $k; ?></h5>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ======================================================
     PRODUK TERBARU
====================================================== -->
<section class="container py-5 bg-grid">
  <h2 class="pixel-font text-center mb-4">PRODUK TERBARU</h2>

  <div class="row g-4">
    <?php for ($i = 1; $i <= 4; $i++): ?>
      <div class="col-md-3">
        <div class="card bg-dark text-light p-3 pixel-card h-100">
          <img src="https://dummyimage.com/300x200/000/fff&text=NEW"
               class="card-img-top border border-dark mb-2"
               alt="Produk Baru">
          <h6 class="pixel-font">Produk Baru <?= $i; ?></h6>
          <span class="text-info fw-bold">Rp 1.000.000</span>
        </div>
      </div>
    <?php endfor; ?>
  </div>
</section>

<!-- ======================================================
     BANNER RAKIT PC
====================================================== -->
<section class="container py-5 text-center bg-grid">
  <div class="card bg-dark text-light p-5 pixel-card">
    <h2 class="pixel-font mb-3">RAKIT PC IMPIANMU</h2>
    <p class="mb-4">
      Bingung memilih komponen?
      Konsultasikan kebutuhanmu dan kami bantu rakitkan PC terbaik.
    </p>
    <a href="#" class="pixel-btn">
      MULAI RAKIT
    </a>
  </div>
</section>

<!-- ======================================================
     FAQ (GANTI PARTNER & REKOMENDASI)
====================================================== -->
<section class="container py-5 bg-grid">
  <h2 class="pixel-font text-center mb-4">PERTANYAAN UMUM (FAQ)</h2>

  <div class="accordion" id="faqAccordion">

    <div class="accordion-item bg-dark text-light border-0 mb-3 pixel-card">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed bg-dark text-light"
                data-bs-toggle="collapse"
                data-bs-target="#faq1">
          Apakah semua produk original?
        </button>
      </h2>
      <div id="faq1" class="accordion-collapse collapse">
        <div class="accordion-body">
          Ya. Semua produk yang dijual Zettarig adalah barang original
          dan bergaransi resmi distributor.
        </div>
      </div>
    </div>

    <div class="accordion-item bg-dark text-light border-0 mb-3 pixel-card">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed bg-dark text-light"
                data-bs-toggle="collapse"
                data-bs-target="#faq2">
          Apakah bisa rakit PC sesuai budget?
        </button>
      </h2>
      <div id="faq2" class="accordion-collapse collapse">
        <div class="accordion-body">
          Bisa. Kamu bisa konsultasi gratis untuk menentukan spesifikasi
          terbaik sesuai kebutuhan dan budget.
        </div>
      </div>
    </div>

    <div class="accordion-item bg-dark text-light border-0 mb-3 pixel-card">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed bg-dark text-light"
                data-bs-toggle="collapse"
                data-bs-target="#faq3">
          Pengiriman aman untuk hardware?
        </button>
      </h2>
      <div id="faq3" class="accordion-collapse collapse">
        <div class="accordion-body">
          Kami menggunakan bubble wrap tebal dan packing tambahan
          untuk memastikan hardware aman sampai tujuan.
        </div>
      </div>
    </div>

    <div class="accordion-item bg-dark text-light border-0 pixel-card">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed bg-dark text-light"
                data-bs-toggle="collapse"
                data-bs-target="#faq4">
          Apakah bisa COD?
        </button>
      </h2>
      <div id="faq4" class="accordion-collapse collapse">
        <div class="accordion-body">
          Metode pembayaran tergantung kebijakan akun dan area.
          Informasi lengkap tersedia saat checkout.
        </div>
      </div>
    </div>

  </div>
</section>
