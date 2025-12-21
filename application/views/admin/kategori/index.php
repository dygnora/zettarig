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

<section class="content">
  <div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
      
      <a href="<?= base_url('admin/kategori/create'); ?>" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Tambah Kategori
      </a>

      <form method="get" action="<?= base_url('admin/kategori'); ?>">
        <div class="input-group" style="width: 250px;">
          <input type="text" 
                 name="q" 
                 class="form-control" 
                 placeholder="Cari kategori..." 
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
        <h3 class="card-title">Daftar Kategori Produk</h3>
      </div>

      <div class="card-body table-responsive p-0">
        
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th style="width: 50px">No</th>
              <th>Nama Kategori</th>
              <th>Deskripsi</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width: 150px">Aksi</th>
            </tr>
          </thead>
          
          <tbody>
            <?php if (!empty($kategori)) : ?>
              <?php $no = 1 + ($offset ?? 0); ?>
              <?php foreach ($kategori as $k) : ?>
                <tr>
                  <td><?= $no++; ?></td>

                  <td>
                    <strong><?= htmlspecialchars($k->nama_kategori); ?></strong>
                  </td>

                  <td>
                    <?php if ($k->deskripsi): ?>
                      <span class="text-muted">
                        <?= character_limiter(strip_tags($k->deskripsi), 50); ?>
                      </span>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    <?php if ($k->status_aktif): ?>
                      <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                      <span class="badge badge-secondary">Nonaktif</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center">
                    
                    <a href="<?= base_url('admin/kategori/edit/'.$k->id_kategori); ?>" 
                       class="btn btn-sm btn-warning mr-1" 
                       title="Edit Kategori">
                       <i class="fas fa-edit"></i>
                    </a>

                    <?php if ($k->status_aktif): ?>
                      <a href="<?= base_url('admin/kategori/nonaktif/'.$k->id_kategori); ?>" 
                         class="btn btn-sm btn-danger" 
                         title="Nonaktifkan"
                         onclick="return confirm('Nonaktifkan kategori ini? Produk di dalamnya akan ikut tersembunyi.')">
                         <i class="fas fa-times"></i>
                      </a>
                    <?php else: ?>
                      <a href="<?= base_url('admin/kategori/aktif/'.$k->id_kategori); ?>" 
                         class="btn btn-sm btn-success" 
                         title="Aktifkan"
                         onclick="return confirm('Aktifkan kembali kategori ini?')">
                         <i class="fas fa-check"></i>
                      </a>
                    <?php endif; ?>

                  </td>
                </tr>
              <?php endforeach; ?>
            
            <?php else : ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-3">
                  <i class="fas fa-folder-open mb-2"></i><br>
                  Data kategori tidak ditemukan.
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