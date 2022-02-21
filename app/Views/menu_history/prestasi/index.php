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
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">History</a></li>
                    <li class="breadcrumb-item active">Prestasi</li>
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
        <div class="card">
            <div class="card-header">
                <?= form_open(route_to('history_prestasi_index'), ['method' => 'get', 'id' => 'storeForm']); ?>
                <div class="row align-items-end">
                    <div class="col-12 col-md-3 pb-3 pb-md-0">
                        <?= form_label('Filter Tahun Ajar', 'tahunAjar') ?>
                        <?= form_dropdown(
                            'id_tahun',
                            $tahun_ajar,
                            set_value('tahun_ajar_selected') == false && isset($id_tahun_selected) ? $id_tahun_selected : set_value('tahun_ajar_selected'),
                            ['class' => 'form-control', 'id' => 'tahunAjar']
                        );
                        ?>
                    </div>
                    <div class="col-12 col-md-3 pb-3 pb-md-0">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <?php if (isset($prestasi) and $prestasi == null) : ?>
                <table class="table table-hover mt-2 text-center">
                    <tr>
                        <td><strong>History Tidak Ditemukan</strong></td>
                    </tr>
                </table>
            <?php endif; ?>
        </div>
        <?php if (!isset($no_tahun_selected)) : ?>
            <?= $this->include('menu_history/prestasi/table') ?>
        <?php else : ?>
            <?= $this->include('menu_history/prestasi/no_tahun_selected') ?>
        <?php endif; ?>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>