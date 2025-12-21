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

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card card-dark">

      <div class="card-header">
        <h3 class="card-title">Daftar Pembayaran Transfer</h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th style="width: 50px">No</th>
              <th>Tanggal</th>
              <th>Customer</th>
              <th>Total Bayar</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width: 150px">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <?php if (!empty($pembayaran)) : ?>
              <?php $no = 1 + ($offset ?? 0); ?>
              <?php foreach ($pembayaran as $p): ?>
                <tr>
                  <td><?= $no++; ?></td>

                  <td>
                    <?= date('d-m-Y H:i', strtotime($p->tanggal_upload)); ?>
                  </td>

                  <td>
                    <strong><?= htmlspecialchars($p->nama_customer); ?></strong>
                  </td>

                  <td>
                    Rp <?= number_format($p->jumlah_dibayar, 0, ',', '.'); ?>
                  </td>

                  <td class="text-center">
                    <?php if ($p->status_verifikasi === 'menunggu'): ?>
                      <span class="badge badge-warning">Menunggu</span>
                    <?php elseif ($p->status_verifikasi === 'diterima'): ?>
                      <span class="badge badge-success">Diterima</span>
                    <?php else: ?>
                      <span class="badge badge-danger">Ditolak</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    <a href="<?= base_url('admin/pembayaran/detail/'.$p->id_pembayaran); ?>"
                       class="btn btn-info btn-sm" title="Lihat Detail & Bukti">
                      <i class="fas fa-eye"></i>
                    </a>

                    <?php if ($p->status_verifikasi === 'menunggu'): ?>
                      <a href="<?= base_url('admin/pembayaran/verifikasi/'.$p->id_pembayaran.'/diterima'); ?>"
                         class="btn btn-success btn-sm"
                         onclick="return confirm('Terima pembayaran ini? Status pesanan akan berubah jadi DIPROSES.')"
                         title="Terima Pembayaran">
                        <i class="fas fa-check"></i>
                      </a>

                      <a href="<?= base_url('admin/pembayaran/verifikasi/'.$p->id_pembayaran.'/ditolak'); ?>"
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Tolak pembayaran ini? Customer diminta upload ulang.')"
                         title="Tolak Pembayaran">
                        <i class="fas fa-times"></i>
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-3">
                  <i class="fas fa-money-bill-wave mb-2"></i><br>
                  Belum ada data pembayaran transfer
                </td>
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