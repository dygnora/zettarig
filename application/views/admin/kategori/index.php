

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Kategori Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Kategori Produk</li>
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
        <a href="<?= base_url('admin/kategori/create'); ?>" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Kategori
        </a>

        <form method="get" action="<?= base_url('admin/kategori'); ?>">
          <div class="input-group input-group-sm" style="width: 220px;">
            <input type="text"
                   name="q"
                   class="form-control"
                   placeholder="Cari kategori..."
                   value="<?= htmlspecialchars($keyword ?? '', ENT_QUOTES); ?>">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- TABLE CARD -->
      <div class="card">
        <!-- 🔧 HEADER DIKECILKAN -->
        <div class="card-header">
          <h3 class="card-title">Daftar Kategori</h3>
        </div>

        <!-- BODY NORMAL (TIDAK MENTOK) -->
        <div class="card-body py-1">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="width:60px">No</th>
                <th style="width:200px">Nama Kategori</th>
                <th>Deskripsi</th>
                <th style="width:120px" class="text-center">Status</th>
                <th style="width:150px" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($kategori)) : ?>
                <?php $no = 1 + ($offset ?? 0); ?>
                <?php foreach ($kategori as $k) : ?>
                  <tr>
                    <td><?= $no++; ?></td>

                    <td>
                      <strong><?= $k->nama_kategori; ?></strong>
                    </td>

                    <td>
                      <?php if ($k->deskripsi): ?>
                        <?= character_limiter(strip_tags($k->deskripsi), 80); ?>
                      <?php else: ?>
                        <span class="text-muted">–</span>
                      <?php endif; ?>
                    </td>

                    <td class="text-center">
                      <?= $k->status_aktif
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>'; ?>
                    </td>

                    <td class="text-center">
                      <a href="<?= base_url('admin/kategori/edit/'.$k->id_kategori); ?>"
                         class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>

                      <?php if ($k->status_aktif): ?>
                        <a href="<?= base_url('admin/kategori/nonaktif/'.$k->id_kategori); ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Nonaktifkan kategori ini?')">
                          <i class="fas fa-times"></i>
                        </a>
                      <?php else: ?>
                        <a href="<?= base_url('admin/kategori/aktif/'.$k->id_kategori); ?>"
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Aktifkan kategori ini?')">
                          <i class="fas fa-check"></i>
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">
                    Data tidak ditemukan
                  </td>
                </tr>
              <?php endif; ?>

            </tbody>
          </table>
        </div>

        <!-- PAGINATION -->
        <div class="card-footer clearfix">
          <?= $pagination; ?>
        </div>
      </div>

    </div>
  </section>
