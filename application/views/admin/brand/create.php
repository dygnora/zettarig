<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Tambah Brand</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('admin/brand'); ?>">Brand Produk</a></li>
          <li class="breadcrumb-item active">Tambah</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Tambah Brand</h3>
      </div>

      <form action="<?= base_url('admin/brand/store'); ?>"
            method="post"
            enctype="multipart/form-data">

        <div class="card-body">

          <div class="form-group">
            <label>Nama Brand</label>
            <input type="text"
                   name="nama_brand"
                   class="form-control"
                   required>
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                      class="form-control"
                      rows="3"></textarea>
          </div>

          <!-- ==================================================
               LOGO BRAND (DEFAULT PREVIEW + LIVE PREVIEW)
               ================================================== -->
          <div class="form-group">
            <label>Logo Brand</label>

            <div class="mb-2">
              <img id="preview-logo"
                   src="<?= base_url('assets/uploads/brand/default.png'); ?>"
                   class="img-thumbnail"
                   style="max-height:120px">
            </div>

            <input type="file"
                   name="logo"
                   id="input-logo"
                   class="form-control-file"
                   accept=".jpg,.jpeg,.png">

            <small class="text-muted">
              JPG / PNG • preview akan muncul otomatis
            </small>
          </div>

          <div class="form-group">
            <label>Status</label>
            <select name="status_aktif" class="form-control">
              <option value="1" selected>Aktif</option>
              <option value="0">Nonaktif</option>
            </select>
          </div>

        </div>

        <div class="card-footer">
          <a href="<?= base_url('admin/brand'); ?>" class="btn btn-secondary btn-sm">
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
