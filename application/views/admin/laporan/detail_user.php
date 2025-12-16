
  <!-- HEADER -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail Laporan Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/laporan'); ?>">Laporan</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTENT -->
  <section class="content">
    <div class="container-fluid">

      <!-- INFO CUSTOMER -->
      <div class="card mb-3">
        <div class="card-body">
          <strong>Customer:</strong>
          <?= htmlspecialchars($customer->nama); ?>
        </div>
      </div>

      <!-- TABEL DETAIL TRANSAKSI -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Riwayat Transaksi</h3>
        </div>

        <div class="card-body py-2">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th width="60">No</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($detail)) : ?>
                <?php $no = 1; foreach ($detail as $d): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y', strtotime($d->tanggal_pesanan)); ?></td>
                    <td><?= strtoupper($d->metode_pembayaran); ?></td>
                    <td><?= ucfirst($d->status_pesanan); ?></td>
                    <td>
                      Rp <?= number_format($d->total_harga, 0, ',', '.'); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">
                    Tidak ada transaksi pada periode ini
                  </td>
                </tr>
              <?php endif; ?>

            </tbody>
          </table>
        </div>

        <div class="card-footer">
          <a href="<?= base_url('admin/laporan'); ?>"
             class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>

      </div>

    </div>
  </section>
