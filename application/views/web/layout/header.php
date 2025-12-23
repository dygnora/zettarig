<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title><?= $title ?? 'Zettarig'; ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=VT323&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="<?= base_url('assets/css/web/theme.css'); ?>?v=<?= time(); ?>">

  <?php if (!empty($page_css)): ?>
    <?php foreach ($page_css as $css): ?>
      <link rel="stylesheet" href="<?= base_url('assets/css/web/'.$css); ?>">
    <?php endforeach; ?>
  <?php endif; ?>

</head>
<body class="d-flex flex-column min-vh-100">