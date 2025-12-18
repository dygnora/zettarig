<?php
$is_login = $this->session->userdata('customer_logged_in');
$customer_name = $this->session->userdata('customer_nama');
$cart_count = ($is_login && isset($this->cart)) ? $this->cart->total_items() : 0;

$current = uri_string();
?>

<div class="pixel-navbar">

  <!-- BRAND -->
  <a href="<?= base_url(); ?>" class="pixel-brand">
    <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Zettarig">
    <span>ZETTARIG</span>
  </a>

  <!-- MENU -->
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
      <a href="<?= base_url('cart'); ?>" class="pixel-tab">
        CART (<?= (int)$cart_count; ?>)
      </a>
    <?php endif; ?>
  </div>

  <!-- USER -->
  <div class="pixel-user">
    <?php if (!$is_login): ?>
      <a href="<?= base_url('auth/login'); ?>" class="pixel-tab pixel-cta">
        LOGIN
      </a>
    <?php else: ?>
      <span class="pixel-user-name">
        <?= htmlspecialchars($customer_name); ?>
      </span>
      <a href="<?= base_url('auth/logout'); ?>" class="pixel-tab">
        LOGOUT
      </a>
    <?php endif; ?>
  </div>

</div>
