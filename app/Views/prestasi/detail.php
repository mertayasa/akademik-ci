<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Prestasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('prestasi_index') ?>">Prestasi</a></li>
                    <li class="breadcrumb-item active">Detail</li>
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

        <!-- Content -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row justify-content-center">
                            <img src="<?= base_url($prestasi['thumbnail']) ?>" style="width: 50%; height: 300px; object-fit:cover" alt="" srcset="">
                            <div class="col-12 text-center">
                                <h4 class="mt-3 mb-0"> <b> <?= $prestasi['nama'] ?> </b></h4>
                                <?= getKategoriPrestasi($prestasi['kategori'], true) ?>
                                <?= getTingkatPrestasi($prestasi['tingkat'], true) ?>
                            </div>

                        </div>

                        <div class="content mt-3 px-2">
                            <?= $prestasi['konten'] ?>
                        </div>

                        <?php if (session()->get('level') == 'admin') : ?>
                            <div class="px-2">
                                <a href="<?= route_to('prestasi_index') ?>" class="btn btn-sm btn-secondary">Kembali</a>
                                <a href="<?= route_to('prestasi_edit', $prestasi['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a onclick="deletePrestasi(this)" data-url="<?= route_to('prestasi_destroy', $prestasi['id']) ?>" class="btn btn-sm btn-danger">Hapus</a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- /.content -->
<?php if (isOrtu() or isSiswa() or isKepsek()) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex flex-column align-items-center">
                <a href="<?= route_to('prestasi_index'); ?>" class="btn btn-info col-1 fixed-bottom mb-3" style="margin:auto; border-radius:10px">
                    <i class="fas fa-angle-double-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->include('prestasi/confirm_del') ?>
<?= $this->endSection() ?>