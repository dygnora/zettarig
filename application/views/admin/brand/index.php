<div class="content-wrapper">

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Brand Produk</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Brand Produk</li>
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
        <a href="<?= base_url('admin/brand/create'); ?>" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Brand
        </a>

        <form method="get" action="<?= base_url('admin/brand'); ?>">
          <div class="input-group input-group-sm" style="width: 220px;">
            <input type="text"
                   name="q"
                   class="form-control"
                   placeholder="Cari brand..."
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
        <div class="card-header">
          <h3 class="card-title">Daftar Brand</h3>
        </div>

        <div class="card-body py-1">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="width:60px">No</th>
                <th style="width:80px" class="text-center">Logo</th>
                <th style="width:200px">Nama Brand</th>
                <th>Deskripsi</th>
                <th style="width:120px" class="text-center">Status</th>
                <th style="width:150px" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($brand)) : ?>
                <?php $no = 1 + ($offset ?? 0); ?>
                <?php foreach ($brand as $b) : ?>
                  <tr>
                    <td><?= $no++; ?></td>

                    <td class="text-center">
                      <?php
                        $logoPath = ($b->logo && file_exists(FCPATH.'assets/uploads/brand/'.$b->logo))
                          ? base_url('assets/uploads/brand/'.$b->logo)
                          : base_url('assets/uploads/brand/default.png');
                      ?>
                      <img src="<?= $logoPath; ?>"
                           alt="Logo Brand"
                           style="height:40px">
                    </td>

                    <td>
                      <strong><?= htmlspecialchars($b->nama_brand); ?></strong>
                    </td>

                    <td>
                      <?= $b->deskripsi
                        ? character_limiter(strip_tags($b->deskripsi), 80)
                        : '<span class="text-muted">–</span>'; ?>
                    </td>

                    <td class="text-center">
                      <?= $b->status_aktif
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>'; ?>
                    </td>

                    <td class="text-center">
                      <a href="<?= base_url('admin/brand/edit/'.$b->id_brand); ?>"
                         class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>

                      <?php if ($b->status_aktif): ?>
                        <a href="<?= base_url('admin/brand/nonaktif/'.$b->id_brand); ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Nonaktifkan brand ini?')">
                          <i class="fas fa-times"></i>
                        </a>
                      <?php else: ?>
                        <a href="<?= base_url('admin/brand/aktif/'.$b->id_brand); ?>"
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Aktifkan brand ini?')">
                          <i class="fas fa-check"></i>
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">
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
</div>
