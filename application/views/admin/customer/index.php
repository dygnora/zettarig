<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Customer</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Customer</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
      <a href="<?= base_url('admin/customer/create'); ?>" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Tambah Customer
      </a>

      <form method="get" action="<?= base_url('admin/customer'); ?>">
        <div class="input-group" style="width: 300px;">
          <input type="text" 
                 name="q" 
                 class="form-control" 
                 placeholder="Cari nama / username / email..." 
                 value="<?= htmlspecialchars($this->input->get('q') ?? '', ENT_QUOTES); ?>">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="card card-dark">

      <div class="card-header">
        <h3 class="card-title">Daftar Customer</h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th style="width: 50px">No</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Email</th>
              <th>No HP</th>
              <th>Alamat</th>
              <th class="text-center">Status</th>
              <th class="text-center">COD</th>
              <th class="text-center" style="width: 150px">Aksi</th>
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
                    <?php if ($c->email): ?>
                        <?= htmlspecialchars($c->email); ?>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if ($c->no_hp): ?>
                        <?= htmlspecialchars($c->no_hp); ?>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if ($c->alamat): ?>
                        <?= character_limiter(strip_tags($c->alamat), 30); ?>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    <?php if ($c->status_aktif): ?>
                        <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Nonaktif</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    <?php if ($c->is_cod_allowed): ?>
                        <span class="badge badge-info">Diizinkan</span>
                    <?php else: ?>
                        <span class="badge badge-danger">Diblokir</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    <a href="<?= base_url('admin/customer/edit/'.$c->id_customer); ?>" 
                       class="btn btn-sm btn-warning mr-1" title="Edit">
                       <i class="fas fa-edit"></i>
                    </a>

                    <?php if ($c->is_cod_allowed): ?>
                      <a href="<?= base_url('admin/customer/block_cod/'.$c->id_customer); ?>" 
                         class="btn btn-sm btn-secondary mr-1" 
                         onclick="return confirm('Blokir COD untuk customer ini?')" title="Blokir COD">
                         <i class="fas fa-ban"></i>
                      </a>
                    <?php else: ?>
                      <a href="<?= base_url('admin/customer/allow_cod/'.$c->id_customer); ?>" 
                         class="btn btn-sm btn-info mr-1" 
                         onclick="return confirm('Izinkan COD untuk customer ini?')" title="Izinkan COD">
                         <i class="fas fa-truck"></i>
                      </a>
                    <?php endif; ?>

                    <?php if ($c->status_aktif): ?>
                      <a href="<?= base_url('admin/customer/nonaktif/'.$c->id_customer); ?>" 
                         class="btn btn-sm btn-danger" 
                         onclick="return confirm('Nonaktifkan customer ini?')" title="Nonaktifkan">
                         <i class="fas fa-times"></i>
                      </a>
                    <?php else: ?>
                      <a href="<?= base_url('admin/customer/aktif/'.$c->id_customer); ?>" 
                         class="btn btn-sm btn-success" 
                         onclick="return confirm('Aktifkan customer ini?')" title="Aktifkan">
                         <i class="fas fa-check"></i>
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-3">
                    <i class="fas fa-users mb-2"></i><br>
                    Data customer tidak ditemukan.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer clearfix">
        <?= $pagination ?? ''; ?>
      </div>

    </div>
  </div>
</section>