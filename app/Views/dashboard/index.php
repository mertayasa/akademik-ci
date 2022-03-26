<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <?php if ((session()->get('level') != 'siswa' and session()->get('level') != "ortu")) : ?>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $count['siswa'] ?></h3>

                            <p>Jumlah Siswa</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <a href="<?= route_to('user_index', 'siswa') ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $count['guru'] ?></h3>

                            <p>Jumlah Guru</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?= route_to('user_index', 'guru') ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $count['ortu'] ?></h3>

                            <p>Jumlah Orang Tua</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= route_to('user_index', 'ortu') ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <?php if (isAdmin()) : ?>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= $count['admin'] ?></h3>

                                <p>Jumlah Admin</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="<?= route_to('user_index', 'admin-kepsek') ?>" class="small-box-footer">Lihat Data <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- ./col -->
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <img src="<?= base_url('default/logo.jpg'); ?>" alt="logo" style="width: 200px;">
                                <h4 class="mt-3">
                                    Hi!, <strong><?= session()->get('nama'); ?></strong>
                                </h4>
                                <h2>Selamat datang di SIAMON SD MUHAMMADIYAH 2 DENPASAR</h2>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?= $this->endSection() ?>