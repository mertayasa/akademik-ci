<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jadwal</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Jadwal</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="d-flex justify-content-end">
                    <a href="<?= route_to('jadwal_pdf', $id_kelas, $id_tahun_ajar) ?>" class="btn btn-primary">Cetak Jadwal</a>
                </div>
                
                <?= $this->include('layouts/flash') ;?>
            
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?= $this->include('jadwal/siswa/table') ?>
            </div>
        </section>
        <!-- /.content -->
<?= $this->endSection() ?>