<div class="content-wrapper">

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Kategori</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/kategori'); ?>">Kategori Produk</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Form Edit Kategori</h3>
        </div>

        <form action="<?= base_url('admin/kategori/update/'.$kategori->id_kategori); ?>"
              method="post">

          <div class="card-body py-2">

            <!-- Nama Kategori -->
            <div class="form-group">
              <label>Nama Kategori</label>
              <input type="text"
                     name="nama_kategori"
                     class="form-control"
                     value="<?= htmlspecialchars($kategori->nama_kategori); ?>"
                     required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea name="deskripsi"
                        class="form-control"
                        rows="3"><?= htmlspecialchars($kategori->deskripsi); ?></textarea>
            </div>

          </div>

          <div class="card-footer">
            <a href="<?= base_url('admin/kategori'); ?>"
               class="btn btn-secondary btn-sm">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <button type="submit"
                    class="btn btn-primary btn-sm float-right">
              <i class="fas fa-save"></i> Simpan Perubahan
            </button>
          </div>

        </form>

      </div>

    </div>
  </section>
</div>
