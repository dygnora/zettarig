<!-- ==================================================
     CONTENT HEADER
================================================== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detail Laporan Supplier</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/laporan/pembelian'); ?>">
              Laporan Pembelian
            </a>
          </li>
          <li class="breadcrumb-item active">Detail</li>
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

    <!-- INFO SUPPLIER -->
    <div class="card card-outline card-primary mb-3">
      <div class="card-body">
        <strong>Supplier :</strong>
        <?= htmlspecialchars($supplier->nama_supplier); ?>
      </div>
    </div>

    <!-- TABEL DETAIL -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-boxes mr-1"></i>
          Detail Produk yang Dibeli
        </h3>
      </div>

      <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
          <thead class="thead-light">
            <tr>
              <th width="50">No</th>
              <th>Tanggal</th>
              <th>Nama Produk</th>
              <th width="80">Qty</th>
              <th width="150">Harga Modal</th>
              <th width="180">Subtotal</th>
            </tr>
          </thead>
          <tbody>

            <?php
              $no = 1;
              $grand_total = 0;
            ?>

            <?php if (!empty($detail)) : ?>
              <?php foreach ($detail as $d) : ?>
                <?php $grand_total += $d->subtotal; ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= date('d-m-Y', strtotime($d->tanggal_pembelian)); ?></td>
                  <td><?= htmlspecialchars($d->nama_produk); ?></td>
                  <td class="text-center"><?= (int) $d->jumlah_beli; ?></td>
                  <td>Rp <?= number_format($d->harga_modal_satuan, 0, ',', '.'); ?></td>
                  <td>Rp <?= number_format($d->subtotal, 0, ',', '.'); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-3">
                  Tidak ada data pembelian
                </td>
              </tr>
            <?php endif; ?>

          </tbody>

          <?php if (!empty($detail)) : ?>
          <tfoot>
            <tr>
              <th colspan="5" class="text-right">TOTAL PEMBELIAN</th>
              <th>Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
            </tr>
          </tfoot>
          <?php endif; ?>

        </table>
      </div>

      <div class="card-footer">
        <a href="<?= base_url('admin/laporan/pembelian?start='.$start.'&end='.$end); ?>"
           class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>
    </div>

  </div>
</section>
