<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<section class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1>Tambah Pengguna</h1>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?= route_to('dashboard') ?>">Dashboard</a></li>
                  <li class="breadcrumb-item active"><a href="<?= route_to('user_index', $level) ?>">Pengguna</a></li>
                  <li class="breadcrumb-item active">Tambah</li>
              </ol>
          </div>
      </div>
  </div>
</section>

<section class="section px-3">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
              <h3 class="card-title">Tambah Pengguna</h3>
          </div>
          <div class="card-body">
            <?= $this->include('layouts/flash') ;?>
            <?= form_open(route_to('user_insert', $level), ['id' => 'storeForm']); ?>
            
                <?= $this->include('user/form_'.$level); ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="<?= route_to('user_index', $level) ?>" class="btn btn-secondary">Kembali</a>
                        <button class="btn btn-primary ml-3" type="submit">Simpan</button>
                    </div>
                </div>
            <?= form_close() ?>

          </div>
        </div>
      </div>
    </div>
  </section>
<?= $this->endSection(); ?>
