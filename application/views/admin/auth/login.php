<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Zettarig Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css'); ?>">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,0.15);
        }

        /* ===== FIX AUTOFILL BROWSER ===== */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        select:-webkit-autofill {
            -webkit-text-fill-color: #ffffff !important;
            -webkit-box-shadow: 0 0 0px 1000px #343a40 inset !important;
            transition: background-color 9999s ease-in-out 0s;
            caret-color: #ffffff;
        }
    </style>

</head>

<body class="hold-transition dark-mode login-page">

<div class="login-box">

  <div class="glass-card p-4 shadow-lg">

    <div class="text-center mb-4">
      <i class="fas fa-shield-alt fa-3x text-primary mb-2"></i>
      <h3 class="font-weight-bold mb-0">ZETTARIG</h3>
      <small class="text-muted">Admin Secure Access</small>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger text-sm">
        <?= $this->session->flashdata('error'); ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/login/process'); ?>" method="post">

        <!-- USERNAME -->
        <div class="input-group mb-3">
            <input
            type="text"
            name="username"
            class="form-control form-control-lg bg-dark text-white"
            placeholder="Username"
            autofocus
            required
            >
            <div class="input-group-append">
            <div class="input-group-text bg-dark text-white">
                <span class="fas fa-user"></span>
            </div>
            </div>
        </div>

        <!-- PASSWORD -->
        <div class="input-group mb-4">
            <input
            type="password"
            name="password"
            class="form-control form-control-lg bg-dark text-white"
            placeholder="Password"
            required
            >
            <div class="input-group-append">
            <div class="input-group-text bg-dark text-white">
                <span class="fas fa-lock"></span>
            </div>
            </div>
        </div>

        <button class="btn btn-primary btn-lg btn-block mt-3">
            <i class="fas fa-sign-in-alt mr-1"></i> Login
        </button>

    </form>


  </div>

  <p class="text-center text-muted mt-3 text-sm">
    © <?= date('Y'); ?> Zettarig
  </p>

</div>

<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js'); ?>"></script>

</body>
</html>
