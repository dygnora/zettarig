<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
            <a href="<?= base_url('admin/pembayaran'); ?>">Pembayaran</a>
          </li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">Info Pembayaran</h3>
                    <p class="text-muted text-center">Pesanan #<?= $pembayaran->id_penjualan; ?></p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Customer</b> <a class="float-right"><?= htmlspecialchars($pembayaran->nama_customer); ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right"><?= htmlspecialchars($pembayaran->email); ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>No HP</b> <a class="float-right"><?= htmlspecialchars($pembayaran->no_hp); ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Total Tagihan</b> 
                            <a class="float-right">Rp <?= number_format($pembayaran->total_harga, 0, ',', '.'); ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Jumlah Dibayar</b> 
                            <a class="float-right text-success font-weight-bold">
                                Rp <?= number_format($pembayaran->jumlah_dibayar, 0, ',', '.'); ?>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Status</b> 
                            <a class="float-right">
                                <?php if ($pembayaran->status_verifikasi === 'menunggu'): ?>
                                  <span class="badge badge-warning">Menunggu Verifikasi</span>
                                <?php elseif ($pembayaran->status_verifikasi === 'diterima'): ?>
                                  <span class="badge badge-success">Diterima</span>
                                <?php else: ?>
                                  <span class="badge badge-danger">Ditolak</span>
                                <?php endif; ?>
                            </a>
                        </li>
                    </ul>

                    <?php if ($pembayaran->status_verifikasi === 'menunggu'): ?>
                        <div class="row">
                            <div class="col-6">
                                <a href="<?= base_url('admin/pembayaran/verifikasi/'.$pembayaran->id_pembayaran.'/diterima'); ?>" 
                                   class="btn btn-success btn-block"
                                   onclick="return confirm('Yakin TERIMA pembayaran ini? Status pesanan akan lanjut DIPROSES.')">
                                   <i class="fas fa-check"></i> Terima
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= base_url('admin/pembayaran/verifikasi/'.$pembayaran->id_pembayaran.'/ditolak'); ?>" 
                                   class="btn btn-danger btn-block"
                                   onclick="return confirm('Yakin TOLAK bukti ini?')">
                                   <i class="fas fa-times"></i> Tolak
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light text-center border">
                            Verifikasi selesai pada:<br>
                            <strong><?= date('d M Y H:i', strtotime($pembayaran->tanggal_verifikasi)); ?></strong>
                        </div>
                    <?php endif; ?>
                    
                    <a href="<?= base_url('admin/pembayaran'); ?>" class="btn btn-default btn-block mt-3">
                        <i class="fas fa-arrow-left"></i> Kembali ke List
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Bukti Transfer</h3>
                </div>
                <div class="card-body text-center bg-dark">
                  <?php if ($pembayaran->bukti_transfer): ?>
                    <img src="<?= base_url('assets/uploads/bukti_transfer/'.$pembayaran->bukti_transfer); ?>"
                         class="img-fluid border"
                         style="max-height: 500px;"
                         alt="Bukti Transfer">
                    <p class="mt-2 text-white small">Nama File: <?= $pembayaran->bukti_transfer; ?></p>
                  <?php else: ?>
                    <div class="py-5 text-muted">
                        <i class="fas fa-image fa-3x mb-3"></i><br>
                        Belum ada bukti transfer yang diupload.
                    </div>
                  <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

  </div>
</section>