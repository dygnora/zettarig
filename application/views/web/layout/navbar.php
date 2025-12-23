<?php
$is_login      = $this->session->userdata('customer_logged_in');
$customer_name = $this->session->userdata('customer_nama');
$cart_count    = ($is_login && isset($this->cart)) ? $this->cart->total_items() : 0;
$current       = uri_string();

// ============================================================
// LOGIC FOTO PROFIL (TAMBAHAN BARU)
// ============================================================
$avatar = ''; 
if ($is_login) {
    $sess_foto = $this->session->userdata('customer_foto');
    $foto_path = FCPATH . 'assets/uploads/profil/' . $sess_foto;

    // Cek file fisik + Cache Buster (?v=time) agar foto langsung berubah
    if (!empty($sess_foto) && file_exists($foto_path)) {
        $avatar = base_url('assets/uploads/profil/' . $sess_foto) . '?v=' . time();
    } else {
        // Default Avatar jika belum upload
        $avatar = 'https://api.dicebear.com/9.x/pixel-art/svg?seed=' . urlencode($customer_name);
    }
}
?>

<div class="pixel-navbar">

  <a href="<?= base_url(); ?>" class="pixel-brand">
    <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Zettarig">
    <span>ZETTARIG</span>
  </a>

  <div class="pixel-menu">
    <a href="<?= base_url(); ?>"
       class="pixel-tab <?= $current === '' ? 'active' : ''; ?>">
      HOME
    </a>

    <a href="<?= base_url('produk'); ?>"
       class="pixel-tab <?= strpos($current, 'produk') === 0 ? 'active' : ''; ?>">
      PRODUCT
    </a>

    <a href="<?= base_url('about'); ?>"
       class="pixel-tab <?= strpos($current, 'about') === 0 ? 'active' : ''; ?>">
      ABOUT
    </a>

<?php if ($is_login): ?>
  <a href="<?= base_url('cart'); ?>"
     class="pixel-tab <?= strpos($current, 'cart') === 0 ? 'active' : ''; ?>">
    CART (<?= (int)$cart_count; ?>)
  </a>
<?php endif; ?>

  </div>

  <div class="pixel-user">
    <?php if (!$is_login): ?>

      <a href="<?= base_url('auth/login'); ?>" class="pixel-tab pixel-cta">
        LOGIN
      </a>

    <?php else: ?>

      <a href="<?= base_url('akun'); ?>"
         class="pixel-tab pixel-user-name d-flex align-items-center gap-2 <?= strpos($current, 'akun') === 0 ? 'active' : ''; ?>"
         style="padding-top: 6px; padding-bottom: 6px;">
        
        <img src="<?= $avatar; ?>" 
             alt="User" 
             style="width: 24px; height: 24px; object-fit: cover; border: 2px solid #fff; background: #000; margin-right: 5px;">
        
        <?= htmlspecialchars($customer_name); ?>
      </a>

      <a href="<?= base_url('auth/logout'); ?>" class="pixel-tab bg-danger text-white border-light">
        LOGOUT
      </a>

    <?php endif; ?>
  </div>

</div>