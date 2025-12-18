<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ==================================================
     HEADER
     ================================================== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Penjualan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Penjualan</li>
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
        <h3 class="card-title">Daftar Penjualan</h3>
      </div>

      <!-- BODY TABEL -->
      <div class="card-body py-1">
        <table class="table table-bordered table-hover mb-0">
          <thead>
            <tr>
              <th width="60">No</th>
              <th>Tanggal</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Pembayaran</th>
              <th>Status</th>
              <th width="120" class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody>
            <?php if (!empty($penjualan)) : ?>
              <?php $no = 1 + ($offset ?? 0); ?>
              <?php foreach ($penjualan as $p): ?>
                <tr>
                  <td><?= $no++; ?></td>

                  <td>
                    <?= date('d-m-Y H:i', strtotime($p->tanggal_pesanan)); ?>
                  </td>

                  <td>
                    <?= htmlspecialchars($p->nama_customer); ?>
                  </td>

                  <td>
                    Rp <?= number_format($p->total_harga, 0, ',', '.'); ?>
                  </td>

                  <td>
                    <?= strtoupper($p->metode_pembayaran); ?>
                  </td>

                  <td>
                    <span class="badge badge-info">
                      <?= ucfirst($p->status_pesanan); ?>
                    </span>
                  </td>

                  <td class="text-center">
                    <a href="<?= base_url('admin/penjualan/detail/'.$p->id_penjualan); ?>"
                       class="btn btn-info btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted">
                  Belum ada data penjualan
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
