<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ==================================================
// HELPER : ACTIVE MENU (EXACT CONTROLLER MATCH)
// DESKRIPSI:
// - Menandai menu aktif berdasarkan nama controller
// - Menghindari konflik substring (pembelian vs laporan_pembelian)
// ==================================================

if (!function_exists('active_menu')) {
  function active_menu($controller)
  {
    $CI =& get_instance();

    // nama controller yang sedang dibuka
    $current = strtolower($CI->router->fetch_class());

    // cocokkan EXACT
    return ($current === strtolower($controller)) ? 'active' : '';
  }
}

// ==================================================
// HELPER : ACTIVE TREE (UNTUK SUBMENU)
// ==================================================
if (!function_exists('active_tree')) {
  function active_tree($controllers = [])
  {
    $CI =& get_instance();
    $current = strtolower($CI->router->fetch_class());

    foreach ($controllers as $ctrl) {
      if ($current === strtolower($ctrl)) {
        return 'menu-open';
      }
    }

    return '';
  }
}
