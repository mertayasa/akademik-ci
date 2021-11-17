<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-block" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-block" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif ?>

<?php if (session()->getFlashdata('warning')) : ?>
    <div class="alert alert-warning alert-block" role="alert">
        <?= session()->getFlashdata('warning') ?>
    </div>
<?php endif ?>

<?php if (session()->getFlashdata('info')) : ?>
    <div class="alert alert-info alert-block" role="alert">
        <?= session()->getFlashdata('info') ?>
    </div>
<?php endif ?>

<?= $this->section('scripts') ;?>
    <script>
        $(".alert-block").fadeTo(5000, 500).slideUp(500);
    </script>
<?= $this->endSection() ;?>
