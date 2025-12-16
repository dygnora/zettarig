
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Pembayaran Transfer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Pembayaran Transfer</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Pembayaran Transfer</h3>
        </div>

        <div class="card-body py-2">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th width="60">No</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th width="140" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($pembayaran)) : ?>
                <?php $no=1; foreach ($pembayaran as $p): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($p->tanggal_upload)); ?></td>
                    <td><?= htmlspecialchars($p->nama_customer); ?></td>
                    <td>Rp <?= number_format($p->jumlah_dibayar, 0, ',', '.'); ?></td>
                    <td>
                      <?php if ($p->status_verifikasi == 'menunggu'): ?>
                        <span class="badge badge-warning">Menunggu</span>
                      <?php elseif ($p->status_verifikasi == 'diterima'): ?>
                        <span class="badge badge-success">Diterima</span>
                      <?php else: ?>
                        <span class="badge badge-danger">Ditolak</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">

                      <a href="<?= base_url('admin/pembayaran/detail/'.$p->id_pembayaran); ?>"
                         class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                      </a>

                      <?php if ($p->status_verifikasi == 'menunggu'): ?>
                        <a href="<?= base_url('admin/pembayaran/verifikasi/'.$p->id_pembayaran.'/diterima'); ?>"
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Terima pembayaran ini?')">
                          <i class="fas fa-check"></i>
                        </a>

                        <a href="<?= base_url('admin/pembayaran/verifikasi/'.$p->id_pembayaran.'/ditolak'); ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Tolak pembayaran ini?')">
                          <i class="fas fa-times"></i>
                        </a>
                      <?php endif; ?>

                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">
                    Belum ada data pembayaran transfer
                  </td>
                </tr>
              <?php endif; ?>

            </tbody>
          </table>
        </div>

      </div>

    </div>
  </section>
