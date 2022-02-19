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
        <?= $this->include('profile/card-profile'); ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex flex-column align-items-center">
                <a href="<?= route_to('user_index', $level); ?>" class="btn btn-info col-1 fixed-bottom mb-3" style="margin:auto; border-radius:10px">
                    <i class="fas fa-angle-double-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>