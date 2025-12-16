
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail Pembelian</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/pembelian_supplier'); ?>">Pembelian Supplier</a></li>
            <li class="breadcrumb-item active">Detail</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <div class="card mb-3">
        <div class="card-body">
          <strong>Supplier:</strong> <?= htmlspecialchars($pembelian->nama_supplier); ?><br>
          <strong>Tanggal:</strong> <?= date('d-m-Y', strtotime($pembelian->tanggal_pembelian)); ?>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Item Pembelian</h3>
        </div>

        <div class="card-body py-2">
          <table class="table table-bordered table-hover mb-0">
            <thead>
              <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga Modal</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach ($detail as $d): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= htmlspecialchars($d->nama_produk); ?></td>
                  <td><?= $d->jumlah_beli; ?></td>
                  <td>Rp <?= number_format($d->harga_modal_satuan, 0, ',', '.'); ?></td>
                  <td>Rp <?= number_format($d->subtotal, 0, ',', '.'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      </div>

    </div>
  </section>
