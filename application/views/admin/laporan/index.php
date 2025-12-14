<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Laporan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Laporan</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- FILTER -->
      <div class="card mb-3">
        <div class="card-header">
          <h3 class="card-title">Filter Laporan</h3>
        </div>

        <form method="get" action="<?= base_url('admin/laporan'); ?>">
          <div class="card-body">

            <div class="row">

              <div class="col-md-3">
                <div class="form-group">
                  <label>Mode Laporan</label>
                  <select name="mode" class="form-control">
                    <option value="harian">Harian</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="start" class="form-control">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="end" class="form-control">
                </div>
              </div>

              <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary btn-sm">
                  <i class="fas fa-filter"></i> Tampilkan
                </button>
              </div>

            </div>

          </div>
        </form>
      </div>

      <!-- EXPORT -->
      <div class="mb-3">
        <a href="<?= base_url('admin/laporan/export/pdf'); ?>" class="btn btn-danger btn-sm">
          <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="<?= base_url('admin/laporan/export/excel'); ?>" class="btn btn-success btn-sm">
          <i class="fas fa-file-excel"></i> Export Excel
        </a>
      </div>

      <!-- LAPORAN PER USER -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Laporan Penjualan per Customer</h3>
        </div>

        <div class="card-body py-2">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Total Transaksi</th>
                <th>Total Belanja</th>
                <th width="100" class="text-center">Detail</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($laporan)): ?>
                <?php $no=1; foreach ($laporan as $r): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($r->nama_customer); ?></td>
                    <td><?= $r->total_transaksi; ?></td>
                    <td>Rp <?= number_format($r->total_belanja, 0, ',', '.'); ?></td>
                    <td class="text-center">
                      <a href="<?= base_url('admin/laporan/user/'.$r->id_customer); ?>"
                         class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">
                    Tidak ada data laporan
                  </td>
                </tr>
              <?php endif; ?>

            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>
</div>
