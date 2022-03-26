<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profil <?= ucfirst($level) ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
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
        <?php $count_siswa = count($siswa); ?>
        <?php foreach($siswa as $key => $user): ?>
            <?= view_cell(
                '\App\Libraries\Widget::listSiswa',
                ['user' => $user, 'id' => $user['id'], 'ortu' => $ortu, 'kelas' => $user['kelas'], 'wali_kelas' => $user['wali_kelas'], 'hide' => ($key == ($count_siswa-1) ? false : true)]
            ) ?>
        <?php endforeach; ?>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>