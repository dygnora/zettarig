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

    <div class="d-flex justify-content-between mb-3">
      <a href="<?= base_url('admin/produk/create'); ?>" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> Tambah Produk
      </a>

      <form method="get" action="<?= base_url('admin/produk'); ?>">
        <div class="input-group" style="width: 250px;">
          <input type="text" 
                 name="q" 
                 class="form-control" 
                 placeholder="Cari produk..." 
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
        <h3 class="card-title">Daftar Produk</h3>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap table-striped">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px">No</th>
              <th>Nama Produk</th>
              <th>Kategori</th>
              <th>Brand</th>
              <th class="text-center">Gambar</th>
              <th>Harga</th>
              <th class="text-center">Stok</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width: 150px">Aksi</th>
            </tr>
          </thead>
          
          <tbody>
            <?php if (!empty($produk)) : ?>
              <?php $no = 1 + ($offset ?? 0); ?>
              <?php foreach ($produk as $p) : ?>
                
                <?php
                  // Logic Gambar
                  $imgPath = FCPATH.'assets/uploads/produk/'.$p->gambar_produk;
                  $imgUrl  = ($p->gambar_produk && file_exists($imgPath))
                             ? base_url('assets/uploads/produk/'.$p->gambar_produk)
                             : base_url('assets/img/no-image.png'); // Gunakan placeholder jika kosong
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
                         class="img-fluid img-thumbnail" 
                         alt="Produk"
                         style="height: 50px; width: auto;">
                  </td>

                  <td class="align-middle">
                    Rp <?= number_format($p->harga_jual, 0, ',', '.'); ?>
                  </td>

                  <td class="text-center align-middle">
                    <?= (int) $p->stok; ?>
                  </td>

                  <td class="text-center align-middle">
                    <?php if ($p->status_aktif): ?>
                        <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                        <span class="badge badge-secondary">Nonaktif</span>
                    <?php endif; ?>
                  </td>

                  <td class="text-center align-middle">
                    <a href="<?= base_url('admin/produk/edit/'.$p->id_produk); ?>" 
                       class="btn btn-sm btn-warning mr-1" title="Edit">
                       <i class="fas fa-edit"></i>
                    </a>

                    <?php if ($p->status_aktif): ?>
                      <a href="<?= base_url('admin/produk/nonaktif/'.$p->id_produk); ?>" 
                         class="btn btn-sm btn-danger" 
                         onclick="return confirm('Nonaktifkan produk ini?')" title="Nonaktifkan">
                         <i class="fas fa-times"></i>
                      </a>
                    <?php else: ?>
                      <a href="<?= base_url('admin/produk/aktif/'.$p->id_produk); ?>" 
                         class="btn btn-sm btn-success" 
                         onclick="return confirm('Aktifkan kembali produk ini?')" title="Aktifkan">
                         <i class="fas fa-check"></i>
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-3">
                    <i class="fas fa-box-open mb-2"></i><br>
                    Data produk tidak ditemukan.
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