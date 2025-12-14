<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('admin/customer'); ?>">Customer</a></li>
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
          <h3 class="card-title">Form Edit Customer</h3>
        </div>

        <form action="<?= base_url('admin/customer/update/'.$customer->id_customer); ?>" method="post">

          <div class="card-body">

            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="nama"
                     class="form-control"
                     value="<?= htmlspecialchars($customer->nama); ?>" required>
            </div>

            <div class="form-group">
              <label>Username</label>
              <input type="text"
                     class="form-control"
                     value="<?= htmlspecialchars($customer->username); ?>"
                     disabled>
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email"
                     class="form-control"
                     value="<?= htmlspecialchars($customer->email); ?>">
            </div>

            <div class="form-group">
              <label>Password Baru (opsional)</label>
              <input type="password" name="password" class="form-control">
              <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
            </div>

            <div class="form-group">
              <label>No HP</label>
              <input type="text" name="no_hp"
                     class="form-control"
                     value="<?= htmlspecialchars($customer->no_hp); ?>">
            </div>

            <div class="form-group">
              <label>Alamat</label>
              <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($customer->alamat); ?></textarea>
            </div>

          </div>

          <div class="card-footer">
            <a href="<?= base_url('admin/customer'); ?>" class="btn btn-secondary btn-sm">
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
</div>
