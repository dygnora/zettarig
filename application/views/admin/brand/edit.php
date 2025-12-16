<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Brand</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('admin/brand'); ?>">Brand Produk</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Form Edit Brand</h3>
      </div>

      <form action="<?= base_url('admin/brand/update/'.$brand->id_brand); ?>"
            method="post"
            enctype="multipart/form-data">

        <div class="card-body">

          <div class="form-group">
            <label>Nama Brand</label>
            <input type="text"
                   name="nama_brand"
                   class="form-control"
                   value="<?= htmlspecialchars($brand->nama_brand); ?>"
                   required>
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi"
                      class="form-control"
                      rows="3"><?= htmlspecialchars($brand->deskripsi); ?></textarea>
          </div>

          <!-- ==================================================
               LOGO BRAND (AUTO PREVIEW LOGO LAMA + LIVE PREVIEW)
               ================================================== -->
          <div class="form-group">
            <label>Logo Brand</label>

            <?php
              $logo_lama = !empty($brand->logo)
                ? base_url('assets/uploads/brand/'.$brand->logo)
                : base_url('assets/uploads/brand/default.png');
            ?>

            <div class="mb-2">
              <img id="preview-logo"
                   src="<?= $logo_lama; ?>"
                   class="img-thumbnail"
                   style="max-height:120px">
            </div>

            <input type="file"
                   name="logo"
                   id="input-logo"
                   class="form-control-file"
                   accept=".jpg,.jpeg,.png">

            <small class="text-muted">
              JPG / PNG • kosongkan jika tidak ingin mengganti logo
            </small>
          </div>

        </div>

        <div class="card-footer">
          <a href="<?= base_url('admin/brand'); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
          <button type="submit" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>

      </form>
    </div>

  </div>
</section>
