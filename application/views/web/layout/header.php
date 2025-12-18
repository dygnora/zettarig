<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Zettarig'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Pixel Font -->
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

  <!-- Bootstrap FULL -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Web Theme (MINIMAL & STABLE) -->
  <link rel="stylesheet" href="<?= base_url('assets/css/web/theme.css'); ?>">

  <?php if (!empty($page_css)): ?>
    <?php foreach ($page_css as $css): ?>
      <link rel="stylesheet" href="<?= base_url('assets/css/web/'.$css); ?>">
    <?php endforeach; ?>
  <?php endif; ?>
</head>
<body>
