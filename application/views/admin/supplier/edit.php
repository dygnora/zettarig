

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Supplier</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/supplier'); ?>">Supplier</a></li>
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
          <h3 class="card-title">Form Edit Supplier</h3>
        </div>

        <form action="<?= base_url('admin/supplier/update/'.$supplier->id_supplier); ?>"
              method="post">

          <div class="card-body py-2">

            <div class="form-group">
              <label>Nama Supplier</label>
              <input type="text"
                     name="nama_supplier"
                     class="form-control"
                     value="<?= htmlspecialchars($supplier->nama_supplier); ?>"
                     required>
            </div>

            <div class="form-group">
              <label>Kontak</label>
              <input type="text"
                     name="kontak"
                     class="form-control"
                     value="<?= htmlspecialchars($supplier->kontak); ?>">
            </div>

            <div class="form-group">
              <label>Alamat</label>
              <textarea name="alamat"
                        class="form-control"
                        rows="3"><?= htmlspecialchars($supplier->alamat); ?></textarea>
            </div>

          </div>

          <div class="card-footer">
            <a href="<?= base_url('admin/supplier'); ?>"
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
