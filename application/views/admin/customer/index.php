

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Customer</li>
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
        <a href="<?= base_url('admin/customer/create'); ?>" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i> Tambah Customer
        </a>

        <form method="get" action="<?= base_url('admin/customer'); ?>">
          <div class="input-group input-group-sm" style="width: 300px;">
            <input type="text"
                   name="q"
                   class="form-control"
                   placeholder="Cari nama / username / email..."
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
          <h3 class="card-title">Daftar Customer</h3>
        </div>

        <div class="card-body py-2">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="50">No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th width="130">No HP</th>
                <th>Alamat</th>
                <th width="110" class="text-center">Status</th>
                <th width="150" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php if (!empty($customer)) : ?>
                <?php $no = 1 + ($offset ?? 0); ?>
                <?php foreach ($customer as $c) : ?>
                  <tr>
                    <td><?= $no++; ?></td>

                    <td><strong><?= htmlspecialchars($c->nama); ?></strong></td>

                    <td><?= htmlspecialchars($c->username); ?></td>

                    <td>
                      <?= $c->email
                        ? htmlspecialchars($c->email)
                        : '<span class="text-muted">–</span>'; ?>
                    </td>

                    <td>
                      <?= $c->no_hp
                        ? htmlspecialchars($c->no_hp)
                        : '<span class="text-muted">–</span>'; ?>
                    </td>

                    <td class="alamat-col">
                    <?= $c->alamat
                        ? htmlspecialchars($c->alamat)
                        : '<span class="text-muted">–</span>'; ?>
                    </td>


                    <td class="text-center">
                      <?= $c->status_aktif
                        ? '<span class="badge bg-success">Aktif</span>'
                        : '<span class="badge bg-secondary">Nonaktif</span>'; ?>
                    </td>

                    <td class="text-center">
                      <a href="<?= base_url('admin/customer/edit/'.$c->id_customer); ?>"
                         class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>

                      <?php if ($c->status_aktif): ?>
                        <a href="<?= base_url('admin/customer/nonaktif/'.$c->id_customer); ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Nonaktifkan customer ini?')">
                          <i class="fas fa-times"></i>
                        </a>
                      <?php else: ?>
                        <a href="<?= base_url('admin/customer/aktif/'.$c->id_customer); ?>"
                           class="btn btn-success btn-sm"
                           onclick="return confirm('Aktifkan customer ini?')">
                          <i class="fas fa-check"></i>
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="8" class="text-center text-muted">
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

