<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>COD & DP</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">COD & DP</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card card-dark">
      <div class="card-header">
        <h3 class="card-title">Daftar Pesanan COD</h3>
      </div>
      
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Customer</th>
              <th>Total</th>
              <th>DP Dibayar</th>
              <th>Status DP</th>
              <th>Status Pelunasan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($cod)): ?>
              <?php $no = 1 + ($offset ?? 0); ?>
              <?php foreach($cod as $c): ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= date('d-m-Y H:i', strtotime($c->tanggal_pesanan)); ?></td>
                <td><?= htmlspecialchars($c->nama_customer); ?></td>
                <td>Rp <?= number_format($c->total_harga, 0, ',', '.'); ?></td>
                
                <td>
                    <?php if($c->total_harga < 5000000): ?>
                        <span class="text-muted">-</span>
                    <?php else: ?>
                        Rp <?= number_format($c->dp_dibayar, 0, ',', '.'); ?>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if($c->total_harga < 5000000): ?>
                        <span class="badge badge-secondary" style="font-weight: normal;">Tanpa DP</span>
                    
                    <?php else: ?>
                        <?php if($c->status_dp == 'diterima'): ?>
                            <span class="badge badge-success">Diterima</span>
                        <?php elseif($c->status_dp == 'menunggu'): ?>
                            <span class="badge badge-warning">Menunggu</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Ditolak</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>

                <td class="text-center">
                    <?php if($c->status_pelunasan == 'lunas'): ?>
                        <span class="badge badge-success">Lunas</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Belum</span>
                    <?php endif; ?>
                </td>

                <td class="text-center">
                    <a href="<?= base_url('admin/cod/detail/'.$c->id_cod); ?>" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                    </a>

                    <?php if($c->status_pesanan == 'dikirim' && $c->status_pelunasan != 'lunas'): ?>
                        <a href="<?= base_url('admin/cod/lunasi/'.$c->id_cod); ?>" 
                           class="btn btn-sm btn-success"
                           title="Terima Pelunasan"
                           onclick="return confirm('Konfirmasi: Kurir sudah menyetorkan uang pelunasan?');">
                           <i class="fas fa-money-bill-wave"></i>
                        </a>
                    <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data COD.</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer clearfix">
          <?= $pagination ?? ''; ?>
      </div>
    </div>

  </div>
</section>