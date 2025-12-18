<?php
// ==================================================
// FOOTER + REQUIRED SCRIPTS
// ==================================================
?>

<!-- Main Footer -->
<footer class="main-footer">
  <strong>&copy; <?= date('Y'); ?> ZETTARIG</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Admin Panel</b>
  </div>
</footer>

</div>
<!-- /.wrapper -->

<!-- ==================================================
     REQUIRED SCRIPTS (LOAD ONCE ONLY)
     ================================================== -->

<!-- jQuery -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- overlayScrollbars -->
<script src="<?= base_url('assets/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>

<!-- AdminLTE -->
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js'); ?>"></script>

<!-- ==================================================
     GLOBAL LIVE IMAGE PREVIEW (PRODUK + BRAND)
     ================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ===============================
  // PREVIEW GAMBAR PRODUK
  // ===============================
  const produkInput   = document.getElementById('input-gambar');
  const produkPreview = document.getElementById('preview-gambar');

  if (produkInput && produkPreview) {
    produkInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        produkPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  }

  // ===============================
  // PREVIEW LOGO BRAND
  // ===============================
  const brandInput   = document.getElementById('input-logo');
  const brandPreview = document.getElementById('preview-logo');

  if (brandInput && brandPreview) {
    brandInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        brandPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    });
  }

});
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('input-gambar');
    const preview = document.getElementById('preview-gambar');

    if (!input || !preview) return;

    input.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(this.files[0]);
      } else {
        preview.src = '<?= base_url('assets/uploads/produk/default.png'); ?>';
      }
    });
  });
</script>


</body>
</html>
