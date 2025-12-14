<div class="content-wrapper">

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Produk</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- ACTION BAR -->
      <div class="mb-3 d-flex justify-content-between">
        <a href="<?= base_url('admin/produk/create'); ?>" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Produk
        </a>

        <form method="get" action="<?= base_url('admin/produk'); ?>">
          <div class="input-group input-group-sm" style="width: 260px;">
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
                <th style="width:60px">No</th>
                <th>Nama Produk</th>
                <th style="width:160px">Kategori</th>
                <th style="width:160px">Brand</th>
                <th style="width:140px">Harga</th>
                <th style="width:100px" class="text-center">Status</th>
                <th style="width:150px" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($produk)) : ?>
                <?php $no = 1 + ($offset ?? 0); ?>
                <?php foreach ($produk as $p) : ?>
                  <tr>
                    <td><?= $no++; ?></td>

                    <td>
                      <strong><?= htmlspecialchars($p->nama_produk); ?></strong>
                    </td>

                    <td><?= htmlspecialchars($p->nama_kategori); ?></td>
                    <td><?= htmlspecialchars($p->nama_brand); ?></td>

                    <td>
                      Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?>
                    </td>

                    <td class="text-center">
                      <?= $p->status_aktif
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>'; ?>
                    </td>

                    <td class="text-center">
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
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Aktifkan produk ini?')">
                          <i class="fas fa-check"></i>
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="7" class="text-center text-muted">
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
</div>
