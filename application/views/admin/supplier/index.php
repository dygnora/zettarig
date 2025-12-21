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

<section class="content">
  <div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
      <a href="<?= base_url('admin/supplier/create'); ?>" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Tambah Supplier
      </a>

      <form method="get" action="<?= base_url('admin/supplier'); ?>">
        <div class="input-group" style="width: 250px;">
          <input type="text" 
                 name="q" 
                 class="form-control" 
                 placeholder="Cari supplier..." 
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
        <h3 class="card-title">Daftar Supplier</h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th style="width: 50px">No</th>
              <th>Nama Supplier</th>
              <th>Kontak</th>
              <th>Alamat</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width: 150px">Aksi</th>
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
                    <?php if ($s->kontak): ?>
                        <?= htmlspecialchars($s->kontak); ?>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <?php if ($s->alamat): ?>
                        <?= character_limiter(strip_tags($s->alamat), 50); ?>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    <?php if ($s->status_aktif): ?>
                        <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Nonaktif</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    <a href="<?= base_url('admin/supplier/edit/'.$s->id_supplier); ?>" 
                       class="btn btn-sm btn-warning mr-1" title="Edit">
                       <i class="fas fa-edit"></i>
                    </a>

                    <?php if ($s->status_aktif): ?>
                      <a href="<?= base_url('admin/supplier/nonaktif/'.$s->id_supplier); ?>" 
                         class="btn btn-sm btn-danger" 
                         onclick="return confirm('Nonaktifkan supplier ini?')" title="Nonaktifkan">
                         <i class="fas fa-times"></i>
                      </a>
                    <?php else: ?>
                      <a href="<?= base_url('admin/supplier/aktif/'.$s->id_supplier); ?>" 
                         class="btn btn-sm btn-success" 
                         onclick="return confirm('Aktifkan supplier ini?')" title="Aktifkan">
                         <i class="fas fa-check"></i>
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="6" class="text-center text-muted py-3">
                    <i class="fas fa-truck-loading mb-2"></i><br>
                    Data supplier tidak ditemukan.
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