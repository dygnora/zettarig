
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Pembelian Supplier</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/pembelian_supplier'); ?>">Pembelian Supplier</a></li>
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
          <h3 class="card-title">Form Pembelian Supplier</h3>
        </div>

        <form action="<?= base_url('admin/pembelian_supplier/store'); ?>" method="post">

          <div class="card-body">

            <div class="form-group">
              <label>Supplier</label>
              <select name="id_supplier" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                <?php foreach ($supplier as $s): ?>
                  <option value="<?= $s->id_supplier; ?>">
                    <?= htmlspecialchars($s->nama_supplier); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Produk</label>
              <select name="id_produk" class="form-control" required>
                <option value="">-- Pilih Produk --</option>
                <?php foreach ($produk as $p): ?>
                  <option value="<?= $p->id_produk; ?>">
                    <?= htmlspecialchars($p->nama_produk); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Jumlah Beli</label>
              <input type="number" name="jumlah_beli" class="form-control" min="1" required>
            </div>

            <div class="form-group">
              <label>Harga Modal / Satuan</label>
              <input type="number" name="harga_modal_satuan" class="form-control" min="0" required>
            </div>

          </div>

          <div class="card-footer">
            <a href="<?= base_url('admin/pembelian_supplier'); ?>" class="btn btn-secondary btn-sm">
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
