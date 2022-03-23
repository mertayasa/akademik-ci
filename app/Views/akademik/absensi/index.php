<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Kelas <?= convertRoman($kelas_raw['jenjang']) . '' . $kelas_raw['kode'] . ' Tahun Ajaran ' . $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] ?></h1> -->
                    <h1 class="m-0">Kelas <?= $kelas_raw['jenjang'] . '' . $kelas_raw['kode'] . ' Tahun Ajaran ' . $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('akademik') ?>">Akademik</a></li>
                        <li class="breadcrumb-item active"><?= $breadcrumb; ?></li>
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
            <?php if (session()->get('level') == 'admin') : ?>
                <?= $this->include('includes/form_absensi'); ?>
            <?php endif; ?>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <a href="<?= route_to('detail_absensi', $kelas_raw['id'], $tahun_ajar['id'] ,'ganjil') ?>" class="btn btn-outline-primary btn-block"> <b> Lihat Absensi Semester Ganjil </b> </a>
                </div>
                <div class="col-6">
                    <a href="<?= route_to('detail_absensi', $kelas_raw['id'], $tahun_ajar['id'] ,'genap') ?>" class="btn btn-outline-primary btn-block"> <b> Lihat Absensi Semester Genap </b> </a>
                </div>
            </div>
            <hr>
        </div>
        <div class="container-fluid row pb-5">
            <div class="col-md-12">
                <a href="<?= route_to('akademik_index'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>
