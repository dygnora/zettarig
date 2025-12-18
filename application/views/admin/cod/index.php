<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ==================================================
     HEADER
     ================================================== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>COD & DP</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">COD & DP</li>
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

    <div class="card">

      <div class="card-header">
        <h3 class="card-title">Daftar Pesanan COD</h3>
      </div>

      <!-- BODY -->
      <div class="card-body py-1">
        <table class="table table-bordered table-hover mb-0">
          <thead>
            <tr>
              <th width="60">No</th>
              <th>Tanggal</th>
              <th>Customer</th>
              <th>Total</th>
              <th>DP Dibayar</th>
              <th>Status DP</th>
              <th>Status Pelunasan</th>
              <th width="160" class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <?php if (!empty($cod)) : ?>
              <?php $no = 1 + ($offset ?? 0); ?>
              <?php foreach ($cod as $c): ?>
                <tr>
                  <td><?= $no++; ?></td>

                  <td>
                    <?= date('d-m-Y H:i', strtotime($c->tanggal_pesanan)); ?>
                  </td>

                  <td>
                    <?= htmlspecialchars($c->nama_customer); ?>
                  </td>

                  <td>
                    Rp <?= number_format($c->total_harga, 0, ',', '.'); ?>
                  </td>

                  <td>
                    Rp <?= number_format($c->dp_dibayar, 0, ',', '.'); ?>
                  </td>

                  <td>
                    <?php if ($c->status_dp === 'menunggu'): ?>
                      <span class="badge badge-warning">Menunggu</span>
                    <?php elseif ($c->status_dp === 'diterima'): ?>
                      <span class="badge badge-success">Diterima</span>
                    <?php else: ?>
                      <span class="badge badge-danger">Ditolak</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if ($c->status_pelunasan === 'lunas'): ?>
                      <span class="badge badge-success">Lunas</span>
                    <?php else: ?>
                      <span class="badge badge-secondary">Belum</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">

                    <a href="<?= base_url('admin/cod/detail/'.$c->id_cod); ?>"
                       class="btn btn-info btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>

                    <?php if ($c->status_dp === 'menunggu'): ?>
                      <a href="<?= base_url('admin/cod/verifikasi/'.$c->id_cod.'/diterima'); ?>"
                         class="btn btn-success btn-sm"
                         onclick="return confirm('Terima DP ini?')">
                        <i class="fas fa-check"></i>
                      </a>

                      <a href="<?= base_url('admin/cod/verifikasi/'.$c->id_cod.'/ditolak'); ?>"
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Tolak DP ini?')">
                        <i class="fas fa-times"></i>
                      </a>
                    <?php endif; ?>

                    <?php if (
                      $c->status_dp === 'diterima'
                      && $c->status_pelunasan === 'belum'
                    ): ?>
                      <a href="<?= base_url('admin/cod/lunasi/'.$c->id_cod); ?>"
                         class="btn btn-primary btn-sm"
                         onclick="return confirm('Tandai sebagai lunas?')">
                        <i class="fas fa-money-bill-wave"></i>
                      </a>
                    <?php endif; ?>

                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted">
                  Belum ada data COD
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- ==================================================
           PAGINATION
           ================================================== -->
      <div class="card-footer clearfix">
        <?= $pagination ?? ''; ?>
      </div>

    </div>

  </div>
</section>
