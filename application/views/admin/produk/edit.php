<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Produk</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="<?= base_url('admin/produk'); ?>">Produk</a>
          </li>
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
        <h3 class="card-title">Form Edit Produk</h3>
      </div>

      <form action="<?= base_url('admin/produk/update/'.$produk->id_produk); ?>"
            method="post"
            enctype="multipart/form-data">

        <div class="card-body">

          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text"
                   name="nama_produk"
                   class="form-control"
                   value="<?= htmlspecialchars($produk->nama_produk); ?>"
                   required>
          </div>

          <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control" required>
              <?php foreach ($kategori as $k): ?>
                <option value="<?= $k->id_kategori; ?>"
                  <?= $k->id_kategori == $produk->id_kategori ? 'selected' : ''; ?>>
                  <?= htmlspecialchars($k->nama_kategori); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Brand</label>
            <select name="id_brand" class="form-control" required>
              <?php foreach ($brand as $b): ?>
                <option value="<?= $b->id_brand; ?>"
                  <?= $b->id_brand == $produk->id_brand ? 'selected' : ''; ?>>
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
                <option value="<?= $s->id_supplier; ?>"
                  <?= $s->id_supplier == $produk->id_supplier ? 'selected' : ''; ?>>
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
                   value="<?= $produk->harga_jual; ?>"
                   required>
          </div>

          <!-- ===============================
               STOK PRODUK
               =============================== -->
          <div class="form-group">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   class="form-control"
                   value="<?= (int) $produk->stok; ?>"
                   min="0"
                   required>
          </div>

          <!-- GAMBAR PRODUK -->
          <div class="form-group">
            <label>Gambar Produk</label>

            <?php
              $gambar_lama = !empty($produk->gambar_produk)
                ? base_url('assets/uploads/produk/'.$produk->gambar_produk)
                : base_url('assets/img/no-image.png');
            ?>

            <div class="mb-2">
              <img id="preview-gambar"
                   src="<?= $gambar_lama; ?>"
                   class="img-thumbnail"
                   style="max-height:120px">
            </div>

            <input type="file"
                   name="gambar"
                   id="input-gambar"
                   class="form-control-file"
                   accept=".jpg,.jpeg,.png">

            <small class="text-muted">
              Kosongkan jika tidak ingin mengganti gambar
            </small>
          </div>

        </div>

        <div class="card-footer">
          <a href="<?= base_url('admin/produk'); ?>" class="btn btn-secondary btn-sm">
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
