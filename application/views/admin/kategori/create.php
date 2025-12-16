

  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Kategori</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
              <a href="<?= base_url('admin/kategori'); ?>">Kategori Produk</a>
            </li>
            <li class="breadcrumb-item active">Tambah</li>
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
          <h3 class="card-title">Form Tambah Kategori</h3>
        </div>

        <form action="<?= base_url('admin/kategori/store'); ?>" method="post">
          <div class="card-body">

            <!-- Nama Kategori -->
            <div class="form-group">
              <label>Nama Kategori</label>
              <input type="text"
                     name="nama_kategori"
                     class="form-control"
                     placeholder="Contoh: VGA, Processor, RAM"
                     required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea name="deskripsi"
                        class="form-control"
                        rows="3"
                        placeholder="Deskripsi singkat kategori (opsional)"></textarea>
            </div>

            <!-- Status -->
            <div class="form-group">
              <label>Status</label>
              <select name="status_aktif" class="form-control">
                <option value="1" selected>Aktif</option>
                <option value="0">Nonaktif</option>
              </select>
            </div>

          </div>

          <div class="card-footer">
            <a href="<?= base_url('admin/kategori'); ?>" class="btn btn-secondary btn-sm">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <button type="submit" class="btn btn-primary btn-sm float-right">
              <i class="fas fa-save"></i> Simpan
            </button>
          </div>
        </form>

      </div>

    </div>
  </section>

