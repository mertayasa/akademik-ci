<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nilai</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Nilai</li>
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
        <?= $this->include('nilai/siswa/table') ?>
    </div>
    <?php if (isGuru()) {
        $href = route_to('panel_wali_index');
    } elseif (isAdmin() or isKepsek()) {
        if (getUrlIndex() == 'history-data') {
            $href = route_to('history_akademik_show_student', $anggota_kelas['id_tahun_ajar'], $anggota_kelas['id_kelas']);
        } else {
            $href = route_to('akademik_show_student', $anggota_kelas['id_tahun_ajar'], $anggota_kelas['id_kelas']);
        }
    }
    ?>
    <?php if (!isSiswa()) : ?>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-column align-items-center">
                    <a href="<?= $href; ?>" class="btn btn-info col-1 fixed-bottom mb-3" style="margin:auto; border-radius:10px">
                        <i class="fas fa-angle-double-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<!-- /.content -->
<?= $this->endSection() ?>