<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail COD</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/cod'); ?>">COD & DP</a>
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
          <strong>Customer:</strong> <?= htmlspecialchars($cod->nama_customer); ?><br>
          <strong>Total Harga:</strong>
          Rp <?= number_format($cod->total_harga, 0, ',', '.'); ?><br>
          <strong>DP Dibayar:</strong>
          Rp <?= number_format($cod->dp_dibayar, 0, ',', '.'); ?><br>
          <strong>Status DP:</strong>
          <span class="badge badge-info">
            <?= ucfirst($cod->status_dp); ?>
          </span><br>
          <strong>Status Pelunasan:</strong>
          <span class="badge badge-secondary">
            <?= ucfirst($cod->status_pelunasan); ?>
          </span>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Bukti DP</h3>
        </div>
        <div class="card-body text-center">
          <?php if ($cod->bukti_dp): ?>
            <img src="<?= base_url('uploads/bukti_dp/'.$cod->bukti_dp); ?>"
                 class="img-fluid"
                 style="max-height:400px;">
          <?php else: ?>
            <p class="text-muted">Belum ada bukti DP</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="mt-3">
        <a href="<?= base_url('admin/cod'); ?>" class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>

    </div>
  </section>
</div>
