<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pindah Sekolah <?= ucfirst($tipe) ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pindah Sekolah</li>
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
        <?= form_open(route_to('pindah_sekolah_index', 'masuk'), ['method' => 'get', 'id' => 'storeForm']); ?>
        <div class="row align-items-end mb-3">
            <div class="col-12 col-md-3 pb-3 pb-md-0">
                <?= form_label('Filter Tahun Ajar', 'tahunAjar') ?>
                <?= form_dropdown(
                    'id_tahun',
                    $tahun_ajar,
                    set_value('tahun_ajar_selected') == false && isset($tahun_ajar_selected) ? $tahun_ajar_selected : set_value('tahun_ajar_selected'),
                    ['class' => 'form-control', 'id' => 'tahunAjar']
                );
                ?>
            </div>
            <div class="col-12 col-md-3 pb-3 pb-md-0">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
        <?= form_close() ?>
        <?= $this->include('pindah_sekolah/datatable') ?>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>