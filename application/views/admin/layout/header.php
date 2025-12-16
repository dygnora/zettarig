<?php
// ==================================================
// HEADER LAYOUT (HTML + HEAD + BODY OPEN)
// ==================================================
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'Admin Zettarig'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet"
        href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">

  <!-- overlayScrollbars -->
  <link rel="stylesheet"
        href="<?= base_url('assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">

  <!-- AdminLTE -->
  <link rel="stylesheet"
        href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css'); ?>">
</head>



<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
