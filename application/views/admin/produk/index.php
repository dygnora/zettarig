<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Produk</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Produk</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <!-- ACTION BAR -->
    <div class="mb-3 d-flex justify-content-between">
      <a href="<?= base_url('admin/produk/create'); ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Produk
      </a>

      <form method="get" action="<?= base_url('admin/produk'); ?>">
        <div class="input-group input-group-sm" style="width:260px;">
          <input type="text"
                 name="q"
                 class="form-control"
                 placeholder="Cari produk..."
                 value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES); ?>">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- TABLE -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Produk</h3>
      </div>

      <div class="card-body py-1">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th class="text-center" width="50">No</th>
              <th width="150">Nama Produk</th>
              <th width="80">Kategori</th>
              <th width="80">Brand</th>
              <th width="60" class="text-center">Gambar</th>
              <th width="120">Harga</th>
              <th width="60" class="text-center">Stok</th>
              <th width="80" class="text-center">Status</th>
              <th width="80" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>

          <?php if (!empty($produk)) : ?>
            <?php $no = 1 + ($offset ?? 0); ?>
            <?php foreach ($produk as $p) : ?>

            <?php
              // ==================================================
              // GAMBAR + FALLBACK
              // ==================================================
              $imgPath = FCPATH.'assets/uploads/produk/'.$p->gambar_produk;
              $imgUrl  = base_url('assets/uploads/produk/'.$p->gambar_produk);

              if (empty($p->gambar_produk) || !file_exists($imgPath)) {
                  $imgUrl = base_url('assets/uploads/brand/default.png');
              }
            ?>

              <tr>
                <td class="text-center align-middle"><?= $no++; ?></td>

                <td class="align-middle">
                  <strong><?= htmlspecialchars($p->nama_produk); ?></strong>
                </td>

                <td class="align-middle">
                  <?= htmlspecialchars($p->nama_kategori); ?>
                </td>

                <td class="align-middle">
                  <?= htmlspecialchars($p->nama_brand); ?>
                </td>

                <td class="text-center align-middle">
                  <img src="<?= $imgUrl; ?>"
                       class="img-thumbnail"
                       style="max-height:75px; max-width:100px; object-fit:contain;">
                </td>

                <td class="align-middle">
                  Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?>
                </td>

                <td class="text-center align-middle">
                  <?= (int) $p->stok; ?>
                </td>

                <td class="text-center align-middle">
                  <?= $p->status_aktif
                    ? '<span class="badge bg-success">Aktif</span>'
                    : '<span class="badge bg-secondary">Nonaktif</span>'; ?>
                </td>

                <td class="text-center align-middle">
                  <a href="<?= base_url('admin/produk/edit/'.$p->id_produk); ?>"
                     class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>

                  <?php if ($p->status_aktif): ?>
                    <a href="<?= base_url('admin/produk/nonaktif/'.$p->id_produk); ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Nonaktifkan produk ini?')">
                      <i class="fas fa-times"></i>
                    </a>
                  <?php else: ?>
                    <a href="<?= base_url('admin/produk/aktif/'.$p->id_produk); ?>"
                       class="btn btn-success btn-sm">
                      <i class="fas fa-check"></i>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>

            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="9" class="text-center text-muted">
                Data tidak ditemukan
              </td>
            </tr>
          <?php endif; ?>

          </tbody>
        </table>
      </div>

      <div class="card-footer clearfix">
        <?= $pagination; ?>
      </div>
    </div>

  </div>
</section>
