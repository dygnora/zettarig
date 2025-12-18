<!-- ==================================================
     CONTENT HEADER
================================================== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Laporan Pembelian Supplier</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Laporan Pembelian</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ==================================================
     CONTENT
================================================== -->
<section class="content">
  <div class="container-fluid">

    <!-- FILTER -->
    <div class="card card-outline card-primary mb-3">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter mr-1"></i> Filter Laporan
        </h3>
      </div>

      <form method="get" action="<?= base_url('admin/laporan/pembelian'); ?>">
        <div class="card-body">
          <div class="form-row">

            <div class="form-group col-md-4">
              <label>Tanggal Mulai</label>
              <input type="date"
                     name="start"
                     value="<?= htmlspecialchars($start ?? ''); ?>"
                     class="form-control form-control-sm">
            </div>

            <div class="form-group col-md-4">
              <label>Tanggal Akhir</label>
              <input type="date"
                     name="end"
                     value="<?= htmlspecialchars($end ?? ''); ?>"
                     class="form-control form-control-sm">
            </div>

            <div class="form-group col-md-4 d-flex align-items-end">
              <button class="btn btn-primary btn-sm btn-block">
                <i class="fas fa-search"></i> Tampilkan
              </button>
            </div>

          </div>
        </div>
      </form>
    </div>

    <!-- EXPORT (DISIAPKAN) -->
    <div class="mb-3">
      <a href="#" class="btn btn-danger btn-sm disabled">
        <i class="fas fa-file-pdf"></i> Export PDF
      </a>
      <a href="#" class="btn btn-success btn-sm disabled">
        <i class="fas fa-file-excel"></i> Export Excel
      </a>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-truck mr-1"></i>
          Laporan Pembelian per Supplier
        </h3>
      </div>

      <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
          <thead class="thead-light">
            <tr>
              <th width="50">No</th>
              <th>Supplier</th>
              <th width="180">Tanggal</th>
              <th width="220">Total Pembelian</th>
              <th width="80" class="text-center">Detail</th>
            </tr>
          </thead>
          <tbody>

            <?php if (!empty($laporan)) : ?>
              <?php $no = 1; foreach ($laporan as $r) : ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= htmlspecialchars($r->nama_supplier); ?></td>
                  <td>
                    <?= date('d/m/Y', strtotime($r->tanggal_terakhir)); ?>
                  </td>
                  <td>
                    Rp <?= number_format($r->total_pembelian, 0, ',', '.'); ?>
                  </td>
                  <td class="text-center">
                    <a href="<?= base_url('admin/laporan/pembelian/supplier/'.$r->id_supplier.'?start='.$start.'&end='.$end); ?>"
                       class="btn btn-info btn-xs">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-3">
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
