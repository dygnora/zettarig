<?php $this->load->view('web/layout/header'); ?>
<?php $this->load->view('web/layout/navbar'); ?>

<main class="container my-4">
    <?php if (!empty($content)): ?>
        <?php $this->load->view($content); ?>
    <?php endif; ?>
</main>

<?php $this->load->view('web/layout/footer'); ?>
