<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Laporan Penjualan</h1>
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

    <div class="card card-outline card-primary mb-3">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter mr-1"></i> Filter Laporan
        </h3>
      </div>

      <form method="get" action="<?= base_url('admin/laporan'); ?>">
        <div class="card-body">
          <div class="form-row">
            
            <div class="form-group col-md-4">
              <label>Tanggal Mulai</label>
              <input type="date" name="start" 
                     value="<?= htmlspecialchars($start ?? ''); ?>" 
                     class="form-control form-control-sm">
            </div>

            <div class="form-group col-md-4">
              <label>Tanggal Akhir</label>
              <input type="date" name="end" 
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

    <div class="mb-3">
      <a href="<?= base_url('admin/laporan/export/pdf?start='.$start.'&end='.$end); ?>" 
         class="btn btn-danger btn-sm mr-1">
        <i class="fas fa-file-pdf"></i> Export PDF
      </a>

      <a href="<?= base_url('admin/laporan/export/excel?start='.$start.'&end='.$end); ?>" 
         class="btn btn-success btn-sm">
        <i class="fas fa-file-excel"></i> Export Excel
      </a>
    </div>

    <div class="card card-dark">
      
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-users mr-1"></i> Laporan Penjualan per Customer
        </h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th width="50">No</th>
              <th>Customer</th>
              <th>Tanggal Transaksi</th>
              <th>Jumlah Item</th>
              <th>Total Belanja</th>
              <th width="80" class="text-center">Detail</th>
            </tr>
          </thead>
          
          <tbody>
            <?php if (!empty($laporan)): ?>
              <?php $no = 1; foreach ($laporan as $r): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  
                  <td><?= htmlspecialchars($r->nama_customer); ?></td>
                  
                  <td><?= date('d/m/Y', strtotime($r->tanggal_transaksi)); ?></td>
                  
                  <td><?= $r->total_transaksi; ?> Item</td>
                  
                  <td>Rp <?= number_format($r->total_belanja, 0, ',', '.'); ?></td>
                  
                  <td class="text-center">
                    <a href="<?= base_url('admin/laporan/user/'.$r->id_customer.'?start='.$start.'&end='.$end); ?>" 
                       class="btn btn-info btn-xs" title="Lihat Detail">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-3">
                  <i class="fas fa-folder-open mb-2"></i><br>
                  Tidak ada data laporan pada periode ini.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>

  </div>
</section>