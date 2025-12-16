<?php
// ==================================================
// TEMPLATE ADMIN (NAVBAR + SIDEBAR + CONTENT)
// ==================================================
?>

<?php $this->load->view('admin/layout/header'); ?>

<?php $this->load->view('admin/layout/navbar'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>

<!-- ==================================================
     CONTENT WRAPPER
     ================================================== -->
<div class="content-wrapper">
  <?php $this->load->view($content); ?>
</div>

<?php $this->load->view('admin/layout/footer'); ?>
