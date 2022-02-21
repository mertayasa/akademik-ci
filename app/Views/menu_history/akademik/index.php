<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">History Akademik</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">History Akademik</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <?= $this->include('layouts/flash'); ?>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php if (isset($no_tahun_selected)) : ?>
            <?= $this->include('menu_history/akademik/no_tahun_selected') ?>
        <?php else : ?>
            <?= $this->include('menu_history/akademik/show_kelas') ?>
        <?php endif; ?>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>