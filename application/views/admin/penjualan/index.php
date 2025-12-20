<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Penjualan</h1>
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

<section class="content">
  <div class="container-fluid">

    <div class="card">

      <div class="card-header">
        <h3 class="card-title">Daftar Penjualan</h3>
      </div>

      <div class="card-body py-1">
        <table class="table table-bordered table-hover mb-0">
          <thead>
            <tr>
              <th width="60">No</th>
              <th>Tanggal</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Pembayaran</th>
              <th class="text-center">Status</th>
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

                  <td class="text-center">
                    <?php
                      switch ($p->status_pesanan) {
                        // 1. TAHAP PEMBAYARAN (KUNING)
                        case 'dibuat':
                        case 'menunggu_pembayaran':
                            echo '<span class="badge badge-warning">Menunggu Bayar</span>';
                            break;

                        // 2. TAHAP VERIFIKASI (BIRU MUDA / INFO)
                        case 'menunggu_verifikasi':
                            echo '<span class="badge badge-info">Verifikasi</span>';
                            break;

                        // 3. DIPROSES (BIRU TUA / PRIMARY)
                        case 'diproses':
                            echo '<span class="badge badge-primary">Diproses</span>';
                            break;
                        
                        // 4. DIKIRIM (UNGU / INDIGO - Bawaan AdminLTE)
                        case 'dikirim':
                            echo '<span class="badge bg-purple">Dikirim</span>';
                            break;

                        // 5. SELESAI (HIJAU / SUCCESS)
                        case 'selesai':
                            echo '<span class="badge badge-success">Selesai</span>';
                            break;

                        // 6. BATAL (MERAH / DANGER)
                        case 'dibatalkan':
                            echo '<span class="badge badge-danger">Batal</span>';
                            break;

                        default:
                            echo '<span class="badge badge-secondary">' . ucfirst($p->status_pesanan) . '</span>';
                      }
                    ?>
                  </td>

                  <td class="text-center">
                    <a href="<?= base_url('admin/penjualan/detail/'.$p->id_penjualan); ?>"
                       class="btn btn-info btn-sm">
                      <i class="fas fa-eye"></i> Detail
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

      <div class="card-footer clearfix">
        <?= $pagination ?? ''; ?>
      </div>

    </div>

  </div>
</section>