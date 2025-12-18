<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Tambah Produk</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/produk'); ?>">Produk</a>
          </li>
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
        <h3 class="card-title">Form Tambah Produk</h3>
      </div>

      <form action="<?= base_url('admin/produk/store'); ?>"
            method="post"
            enctype="multipart/form-data">

        <div class="card-body">

          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text"
                   name="nama_produk"
                   class="form-control"
                   required>
          </div>

          <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control" required>
              <option value="">-- Pilih Kategori --</option>
              <?php foreach ($kategori as $k): ?>
                <option value="<?= $k->id_kategori; ?>">
                  <?= htmlspecialchars($k->nama_kategori); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Brand</label>
            <select name="id_brand" class="form-control" required>
              <option value="">-- Pilih Brand --</option>
              <?php foreach ($brand as $b): ?>
                <option value="<?= $b->id_brand; ?>">
                  <?= htmlspecialchars($b->nama_brand); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Supplier</label>
            <select name="id_supplier" class="form-control">
              <option value="">-- Tidak ada --</option>
              <?php foreach ($supplier as $s): ?>
                <option value="<?= $s->id_supplier; ?>">
                  <?= htmlspecialchars($s->nama_supplier); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Harga Jual</label>
            <input type="number"
                   name="harga_jual"
                   class="form-control"
                   required>
          </div>

          <!-- ===============================
               STOK AWAL
               =============================== -->
          <div class="form-group">
            <label>Stok Awal</label>
            <input type="number"
                   name="stok"
                   class="form-control"
                   value="0"
                   min="0"
                   required>
          </div>

          <!-- GAMBAR PRODUK -->
          <div class="form-group">
            <label>Gambar Produk</label>

            <div class="mb-2">
              <img id="preview-gambar"
                   src="<?= base_url('assets/img/no-image.png'); ?>"
                   class="img-thumbnail"
                   style="max-height:120px">
            </div>

            <input type="file"
                   name="gambar"
                   id="input-gambar"
                   class="form-control-file"
                   accept=".jpg,.jpeg,.png">

            <small class="text-muted">
              JPG / PNG • preview muncul otomatis
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
          <a href="<?= base_url('admin/produk'); ?>" class="btn btn-secondary btn-sm">
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
