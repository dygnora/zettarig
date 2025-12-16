
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail Pembayaran Transfer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/pembayaran'); ?>">Pembayaran Transfer</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <div class="card mb-3">
        <div class="card-body">
          <strong>Customer:</strong> <?= htmlspecialchars($pembayaran->nama_customer); ?><br>
          <strong>Email:</strong> <?= htmlspecialchars($pembayaran->email); ?><br>
          <strong>Jumlah Dibayar:</strong>
          Rp <?= number_format($pembayaran->jumlah_dibayar, 0, ',', '.'); ?><br>
          <strong>Status:</strong>
          <span class="badge badge-info">
            <?= ucfirst($pembayaran->status_verifikasi); ?>
          </span>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Bukti Transfer</h3>
        </div>
        <div class="card-body text-center">
          <?php if ($pembayaran->bukti_transfer): ?>
            <img src="<?= base_url('uploads/bukti_transfer/'.$pembayaran->bukti_transfer); ?>"
                 class="img-fluid"
                 style="max-height:400px;">
          <?php else: ?>
            <p class="text-muted">Belum ada bukti transfer</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="mt-3">
        <a href="<?= base_url('admin/pembayaran'); ?>" class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>

    </div>
  </section>