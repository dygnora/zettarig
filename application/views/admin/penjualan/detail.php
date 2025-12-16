
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail Penjualan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/penjualan'); ?>">Penjualan</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- INFO PENJUALAN -->
      <div class="card mb-3">
        <div class="card-body">
          <strong>Customer:</strong> <?= htmlspecialchars($penjualan->nama_customer); ?><br>
          <strong>Email:</strong> <?= htmlspecialchars($penjualan->email); ?><br>
          <strong>No HP:</strong> <?= htmlspecialchars($penjualan->no_hp); ?><br>
          <strong>Alamat:</strong><br>
          <?= nl2br(htmlspecialchars($penjualan->alamat_pengiriman)); ?><br><br>
          <strong>Status:</strong>
          <span class="badge badge-info">
            <?= ucfirst($penjualan->status_pesanan); ?>
          </span>
        </div>
      </div>

      <!-- DETAIL ITEM -->
      <div class="card mb-3">
        <div class="card-header">
          <h3 class="card-title">Produk Dibeli</h3>
        </div>

        <div class="card-body py-2">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th width="60">No</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($detail as $d): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= htmlspecialchars($d->nama_produk); ?></td>
                  <td><?= $d->jumlah; ?></td>
                  <td>Rp <?= number_format($d->harga_satuan, 0, ',', '.'); ?></td>
                  <td>Rp <?= number_format($d->subtotal, 0, ',', '.'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- TIMELINE -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Timeline Pesanan</h3>
        </div>

        <div class="card-body">
          <ul class="mb-0">
            <?php foreach ($timeline as $t): ?>
              <li>
                <strong><?= $t->status_tahap; ?></strong><br>
                <small><?= date('d-m-Y H:i', strtotime($t->waktu)); ?></small>
                <?php if ($t->catatan): ?>
                  <br><em><?= htmlspecialchars($t->catatan); ?></em>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="mt-3">
        <a href="<?= base_url('admin/penjualan'); ?>" class="btn btn-secondary btn-sm">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
      </div>

    </div>
  </section>