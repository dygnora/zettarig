<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Supplier</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/supplier'); ?>">Supplier</a></li>
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
          <h3 class="card-title">Form Tambah Supplier</h3>
        </div>

        <form action="<?= base_url('admin/supplier/store'); ?>" method="post">

          <div class="card-body">

            <div class="form-group">
              <label>Nama Supplier</label>
              <input type="text"
                     name="nama_supplier"
                     class="form-control"
                     placeholder="Contoh: PT Sumber Jaya"
                     required>
            </div>

            <div class="form-group">
              <label>Kontak</label>
              <input type="text"
                     name="kontak"
                     class="form-control"
                     placeholder="No HP / Email (opsional)">
            </div>

            <div class="form-group">
              <label>Alamat</label>
              <textarea name="alamat"
                        class="form-control"
                        rows="3"
                        placeholder="Alamat supplier (opsional)"></textarea>
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
            <a href="<?= base_url('admin/supplier'); ?>" class="btn btn-secondary btn-sm">
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
</div>
