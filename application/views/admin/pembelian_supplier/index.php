<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pembelian Supplier</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Pembelian Supplier</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="mb-3">
      <a href="<?= base_url('admin/pembelian_supplier/create'); ?>"
         class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Pembelian
      </a>
    </div>

    <div class="card">

      <div class="card-header">
        <h3 class="card-title">Riwayat Pembelian</h3>
      </div>

      <div class="card-body py-1">
        <table class="table table-bordered table-hover mb-0">
          <thead>
            <tr>
              <th width="60">No</th>
              <th>Tanggal</th>
              <th>Supplier</th>
              <th>Total Harga</th>
              <th width="120" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($pembelian)) : ?>
              <?php $no = 1 + ($offset ?? 0); ?>
              <?php foreach ($pembelian as $p): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= date('d-m-Y', strtotime($p->tanggal_pembelian)); ?></td>
                  <td><?= htmlspecialchars($p->nama_supplier); ?></td>
                  <td>Rp <?= number_format($p->total_harga, 0, ',', '.'); ?></td>
                  <td class="text-center">
                    <a href="<?= base_url('admin/pembelian_supplier/detail/'.$p->id_pembelian); ?>"
                       class="btn btn-info btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted">
                  Belum ada data pembelian
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- PAGINATION -->
      <div class="card-footer clearfix">
        <?= $pagination ?? ''; ?>
      </div>

    </div>

  </div>
</section>
