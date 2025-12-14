<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('active_menu')) {
  function active_menu($menu)
  {
    $CI =& get_instance();
    $class = strtolower($CI->router->fetch_class());

    /*
      Contoh:
      Kategori_admin  -> kategori_admin
      Produk_admin    -> produk_admin
    */

    // cocokkan: kategori dengan kategori_admin
    if (strpos($class, strtolower($menu)) !== false) {
      return 'active';
    }

    return '';
  }
}

if (!function_exists('active_tree')) {
  function active_tree($menus = [])
  {
    $CI =& get_instance();
    $class = strtolower($CI->router->fetch_class());

    foreach ($menus as $menu) {
      if (strpos($class, strtolower($menu)) !== false) {
        return 'menu-open';
      }
    }

    return '';
  }
}
