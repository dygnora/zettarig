

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Supplier</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Supplier</li>
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
        <a href="<?= base_url('admin/supplier/create'); ?>" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Supplier
        </a>

        <form method="get" action="<?= base_url('admin/supplier'); ?>">
          <div class="input-group input-group-sm" style="width: 220px;">
            <input type="text"
                   name="q"
                   class="form-control"
                   placeholder="Cari supplier..."
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
          <h3 class="card-title">Daftar Supplier</h3>
        </div>

        <div class="card-body py-1">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="width:60px">No</th>
                <th style="width:200px">Nama Supplier</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th style="width:120px" class="text-center">Status</th>
                <th style="width:150px" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($supplier)) : ?>
                <?php $no = 1 + ($offset ?? 0); ?>
                <?php foreach ($supplier as $s) : ?>
                  <tr>
                    <td><?= $no++; ?></td>

                    <td><strong><?= htmlspecialchars($s->nama_supplier); ?></strong></td>

                    <td>
                      <?= $s->kontak
                        ? htmlspecialchars($s->kontak)
                        : '<span class="text-muted">–</span>'; ?>
                    </td>

                    <td>
                      <?= $s->alamat
                        ? character_limiter(strip_tags($s->alamat), 60)
                        : '<span class="text-muted">–</span>'; ?>
                    </td>

                    <td class="text-center">
                      <?= $s->status_aktif
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>'; ?>
                    </td>

                    <td class="text-center">
                      <a href="<?= base_url('admin/supplier/edit/'.$s->id_supplier); ?>"
                         class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>

                      <?php if ($s->status_aktif): ?>
                        <a href="<?= base_url('admin/supplier/nonaktif/'.$s->id_supplier); ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Nonaktifkan supplier ini?')">
                          <i class="fas fa-times"></i>
                        </a>
                      <?php else: ?>
                        <a href="<?= base_url('admin/supplier/aktif/'.$s->id_supplier); ?>"
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Aktifkan supplier ini?')">
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
