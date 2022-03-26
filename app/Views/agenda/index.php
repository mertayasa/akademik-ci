<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kalender Akademik</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kalender Akademik</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            
            <?= $this->include('layouts/flash') ;?>
        
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <?php if (session()->get('level') == 'admin'): ?>
                        <?= $this->include('agenda/datatable') ?>
                    <?php else: ?>
                        <?php if($agenda): ?>
                            <object data="<?= base_url($agenda['file']) ?>" width="100%" height=" <?= str_contains($agenda['file'], '.pdf') ? '600px' : 'auto' ?> "></object>
                        <?php else: ?>
                            <p class="text-center">Belum Ada Kalender Akademik</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
<?= $this->endSection() ?>