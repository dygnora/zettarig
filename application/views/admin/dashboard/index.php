<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <!-- ================= INFO BOX ================= -->
    <div class="row">

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-warning">
          <span class="info-box-icon"><i class="fas fa-box"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Produk</span>
            <span class="info-box-number"><?= $total_produk ?? 0 ?></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-danger">
          <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Stok Menipis</span>
            <span class="info-box-number"><?= $stok_menipis ?? 0 ?></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-info">
          <span class="info-box-icon"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Customer</span>
            <span class="info-box-number"><?= $total_customer ?? 0 ?></span>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-success">
          <span class="info-box-icon"><i class="fas fa-truck"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Supplier</span>
            <span class="info-box-number"><?= $total_supplier ?? 0 ?></span>
          </div>
        </div>
      </div>

    </div>

    <!-- ================= GRAFIK + SUMMARY ================= -->
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Pendapatan Bulanan (12 Bulan Terakhir)</h3>
          </div>

          <div class="card-body">
            <canvas id="chartPendapatan" height="150"></canvas>
          </div>

          <div class="card-footer">
            <div class="row text-center">

              <div class="col-sm-4 col-12">
                <div class="description-block border-right">
                  <h5 class="description-header">
                    Rp <?= number_format($total_revenue ?? 0, 0, ',', '.'); ?>
                  </h5>
                  <span class="description-text">TOTAL PENDAPATAN</span>
                </div>
              </div>

              <div class="col-sm-4 col-12">
                <div class="description-block border-right">
                  <h5 class="description-header">
                    Rp <?= number_format($total_cost ?? 0, 0, ',', '.'); ?>
                  </h5>
                  <span class="description-text">TOTAL PEMBELIAN</span>
                </div>
              </div>

              <div class="col-sm-4 col-12">
                <div class="description-block">
                  <h5 class="description-header">
                    Rp <?= number_format($total_profit ?? 0, 0, ',', '.'); ?>
                  </h5>
                  <span class="description-text">ESTIMASI PROFIT</span>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- ================= LATEST ORDER + ACTION ================= -->
    <div class="row">

      <div class="col-md-8">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Pesanan Terbaru</h3>
            <div class="card-tools">
              <a href="<?= base_url('admin/penjualan'); ?>" class="btn btn-tool">
                <i class="fas fa-external-link-alt"></i>
              </a>
            </div>
          </div>

          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-dark mb-0">
              <thead>
                <tr>
                  <th style="width:90px">ID</th>
                  <th>Customer</th>
                  <th style="width:150px">Total</th>
                  <th style="width:140px">Metode</th>
                  <th style="width:140px">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($latest_orders)): ?>
                  <?php foreach ($latest_orders as $o): ?>
                    <tr>
                      <td>#<?= $o->id_penjualan; ?></td>
                      <td><?= htmlspecialchars($o->nama_customer); ?></td>
                      <td>Rp <?= number_format($o->total_harga, 0, ',', '.'); ?></td>
                      <td>
                        <span class="badge bg-info">
                          <?= strtoupper($o->metode_pembayaran); ?>
                        </span>
                      </td>
                      <td>
                        <?= badge_status_pesanan($o->status_pesanan); ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted">
                      Belum ada pesanan
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="col-md-4">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Aksi Cepat</h3>
          </div>
          <div class="card-body">
            <a href="<?= base_url('admin/produk/create'); ?>" class="btn btn-primary btn-sm mb-2 d-block">
              <i class="fas fa-plus"></i> Tambah Produk
            </a>
            <a href="<?= base_url('admin/pembelian'); ?>" class="btn btn-warning btn-sm mb-2 d-block">
              <i class="fas fa-truck-loading"></i> Pembelian Supplier
            </a>
            <a href="<?= base_url('admin/penjualan'); ?>" class="btn btn-success btn-sm d-block">
              <i class="fas fa-shopping-cart"></i> Lihat Pesanan
            </a>
          </div>
        </div>
      </div>

    </div>

    <!-- ================= STOK MENIPIS ================= -->
    <div class="row">
      <div class="col-md-12">
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Produk Stok Menipis</h3>
          </div>

          <div class="card-body table-responsive p-0">
            <table class="table table-hover table-dark mb-0">
              <thead>
                <tr>
                  <th>Produk</th>
                  <th style="width:120px" class="text-center">Stok</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($produk_stok_menipis)): ?>
                  <?php foreach ($produk_stok_menipis as $p): ?>
                    <tr>
                      <td><?= htmlspecialchars($p->nama_produk); ?></td>
                      <td class="text-center">
                        <span class="badge bg-danger"><?= $p->stok; ?></span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="2" class="text-center text-muted">
                      Tidak ada produk stok menipis
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>
