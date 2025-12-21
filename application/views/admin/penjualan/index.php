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

    <div class="card card-dark">

      <div class="card-header">
        <h3 class="card-title">Daftar Penjualan Masuk</h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th style="width: 50px">No</th>
              <th>Tanggal</th>
              <th>Customer</th>
              <th>Total</th>
              <th>Pembayaran</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width: 100px">Aksi</th>
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
                    <strong><?= htmlspecialchars($p->nama_customer); ?></strong>
                  </td>

                  <td>
                    Rp <?= number_format($p->total_harga, 0, ',', '.'); ?>
                  </td>

                  <td>
                    <span class="badge badge-light border">
                        <?= strtoupper($p->metode_pembayaran); ?>
                    </span>
                  </td>

                  <td class="text-center">
                    <?php
                      switch ($p->status_pesanan) {
                        // 1. TAHAP PEMBAYARAN (KUNING)
                        case 'dibuat':
                        case 'menunggu_pembayaran':
                            echo '<span class="badge badge-warning">Menunggu Bayar</span>';
                            break;

                        // 2. TAHAP VERIFIKASI (BIRU MUDA)
                        case 'menunggu_verifikasi':
                            echo '<span class="badge badge-info">Verifikasi</span>';
                            break;

                        // 3. DIPROSES (BIRU TUA)
                        case 'diproses':
                            echo '<span class="badge badge-primary">Diproses</span>';
                            break;
                        
                        // 4. DIKIRIM (UNGU)
                        case 'dikirim':
                            echo '<span class="badge bg-purple">Dikirim</span>';
                            break;

                        // 5. SELESAI (HIJAU)
                        case 'selesai':
                            echo '<span class="badge badge-success">Selesai</span>';
                            break;

                        // 6. BATAL (MERAH)
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
                       class="btn btn-info btn-sm" title="Lihat Detail">
                       <i class="fas fa-eye"></i> Detail
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-3">
                    <i class="fas fa-shopping-cart mb-2"></i><br>
                    Belum ada data penjualan.
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