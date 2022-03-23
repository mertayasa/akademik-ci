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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Semester Ganjil</h4>
                    </div>

                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="accordion" id="accordionGanjil">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingGanjil">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseGanjil" aria-expanded="true" aria-controls="collapseGanjil">
                                            Lihat Absensi Semester Ganjil
                                            </button>
                                        </h2>
                                        </div>
    
                                        <div id="collapseGanjil" class="collapse" aria-labelledby="headingGanjil" data-parent="#accordionGanjil">
                                        <div class="card-body">
                                            <div class="col-12 mt-3" id="tabelAbsensiGanjil">
                                                <?= $this->include('includes/table_absensi_ganjil'); ?>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Semester Genap</h4>
                    </div>

                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="accordion" id="accordionExample">
                                    <div class="card mb-0">
                                        <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Lihat Absensi Semester Genap
                                            </button>
                                        </h2>
                                        </div>
    
                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="col-12 mt-3" id="tabelAbsensiGenap">
                                                <?= $this->include('includes/table_absensi_genap'); ?>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="<?= route_to('akademik_index'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
