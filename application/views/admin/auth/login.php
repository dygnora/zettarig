<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Zettarig Admin | Secure Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">

  <!-- AdminLTE -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css'); ?>">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top right, #1e3a8a, #0f172a);
      height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Background glow */
    body::before {
      content: "";
      position: absolute;
      width: 320px;
      height: 320px;
      background: rgba(59,130,246,.25);
      filter: blur(90px);
      border-radius: 50%;
      top: 8%;
      left: 12%;
      z-index: -1;
    }

    .login-box {
      width: 400px;
    }

    .glass-card {
      background: rgba(255,255,255,.04);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 24px;
      border: 1px solid rgba(255,255,255,.12);
      padding: 40px;
      transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }

    .glass-card:hover {
      transform: translateY(-2px);
      border-color: rgba(59,130,246,.45);
      box-shadow: 0 20px 40px rgba(0,0,0,.35);
    }

    .brand-icon {
      width: 72px;
      height: 72px;
      border-radius: 18px;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 18px;
      box-shadow: 0 12px 24px rgba(37,99,235,.35);
    }

    .form-control {
      background: rgba(255,255,255,.05) !important;
      border: 1px solid rgba(255,255,255,.12) !important;
      border-radius: 12px !important;
      color: #fff !important;
      padding: 12px 15px;
      height: auto;
      transition: all .25s ease;
    }

    .form-control:focus {
      background: rgba(255,255,255,.08) !important;
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 4px rgba(59,130,246,.15);
    }

    .form-control:focus-visible {
      outline: none;
      box-shadow: 0 0 0 4px rgba(59,130,246,.25);
    }

    .input-group-text {
      background: transparent !important;
      border: none !important;
      color: rgba(255,255,255,.65) !important;
      cursor: pointer;
    }

    .btn-primary {
      background: #3b82f6;
      border: none;
      border-radius: 12px;
      padding: 12px;
      font-weight: 600;
      letter-spacing: .4px;
      transition: all .25s ease;
    }

    .btn-primary:hover {
      background: #2563eb;
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(37,99,235,.45);
    }

    .divider {
      height: 1px;
      background: rgba(255,255,255,.08);
      margin: 18px 0 28px;
    }

    .text-muted {
      color: rgba(255,255,255,.55) !important;
    }

    /* Autofill fix */
    input:-webkit-autofill {
      -webkit-text-fill-color: #fff !important;
      -webkit-box-shadow: 0 0 0px 1000px #1e293b inset !important;
    }
  </style>
</head>

<body class="hold-transition dark-mode">

<div class="login-box">

  <div class="glass-card">

    <div class="text-center">
      <div class="brand-icon">
        <i class="fas fa-shield-alt fa-2x text-white"></i>
      </div>
      <h3 class="font-weight-bold text-white mb-1">ZETTARIG</h3>
      <p class="text-muted text-sm mb-0">Secure Administrator Access</p>
    </div>

    <div class="divider"></div>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger border-0 text-sm mb-4"
           style="background: rgba(220,53,69,.2); color:#ff9aa2; border-radius:12px;">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?= $this->session->flashdata('error'); ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/login/process'); ?>" method="post">

      <div class="form-group mb-3">
        <label class="text-xs text-uppercase font-weight-bold text-muted ml-1">
          Username
        </label>
        <div class="input-group">
          <input type="text"
                 name="username"
                 class="form-control"
                 placeholder="Enter username"
                 autofocus
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group mb-4">
        <label class="text-xs text-uppercase font-weight-bold text-muted ml-1">
          Password
        </label>
        <div class="input-group">
          <input type="password"
                 name="password"
                 id="password"
                 class="form-control"
                 placeholder="••••••••"
                 required>
          <div class="input-group-append">
            <div class="input-group-text" id="togglePassword">
              <span class="fas fa-eye"></span>
            </div>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-block">
        Sign In <i class="fas fa-arrow-right ml-2 text-sm"></i>
      </button>

    </form>

  </div>

  <p class="text-center text-muted mt-4 text-xs">
    &copy; <?= date('Y'); ?>
    <span class="text-white font-weight-bold">Zettarig</span> Ecosystem
  </p>

</div>

<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const icon  = this.querySelector('span');

    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });
</script>

</body>
</html>
