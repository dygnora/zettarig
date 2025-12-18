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
              <th width="40">No</th>
              <th width="80" class="text-center">Gambar</th>
              <th>Produk</th>
              <th width="80" class="text-center">Qty</th>
              <th width="150">Harga Modal</th>
              <th width="150">Subtotal</th>
            </tr>
          </thead>
          <tbody>

          <?php if (!empty($detail)) : ?>
            <?php $no = 1; foreach ($detail as $d): ?>

            <?php
              // ==================================================
              // GAMBAR PRODUK + FALLBACK
              // ==================================================
              $imgPath = FCPATH.'assets/uploads/produk/'.$d->gambar_produk;
              $imgUrl  = base_url('assets/uploads/produk/'.$d->gambar_produk);

              if (empty($d->gambar_produk) || !file_exists($imgPath)) {
                  $imgUrl = base_url('assets/uploads/brand/default.png');
              }
            ?>

              <tr>
                <td class="text-center align-middle"><?= $no++; ?></td>

                <td class="text-center align-middle">
                  <img src="<?= $imgUrl; ?>"
                       class="img-thumbnail"
                       style="max-height:70px; max-width:90px; object-fit:contain;">
                </td>

                <td class="align-middle">
                  <?= htmlspecialchars($d->nama_produk); ?>
                </td>

                <td class="text-center align-middle">
                  <?= (int) $d->jumlah_beli; ?>
                </td>

                <td class="align-middle">
                  Rp <?= number_format($d->harga_modal_satuan, 0, ',', '.'); ?>
                </td>

                <td class="align-middle">
                  Rp <?= number_format($d->subtotal, 0, ',', '.'); ?>
                </td>
              </tr>

            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="text-center text-muted">
                Tidak ada item pembelian
              </td>
            </tr>
          <?php endif; ?>

          </tbody>
        </table>
      </div>

    </div>

  </div>
</section>
