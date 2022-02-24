<?= $this->section('styles'); ?>
<style>
    .card-horizontal {
        display: flex;
        flex: 1 1 auto;
    }
</style>
<?= $this->endSection() ?>

<div class="row">
    <?php if (session()->get('level') == 'admin') : ?>
        <div class="d-flex justify-content-end col-12">
            <a href="<?= route_to('prestasi_create') ?>" class="btn btn-primary btn-sm">Tambah Prestasi</a>
        </div>
    <?php endif; ?>
    <?php if ($prestasi != null) : ?>
        <?php foreach ($prestasi as $key => $pres) : ?>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-horizontal">
                        <div class="img-square-wrapper">
                            <img class="" style="width:250px" src="<?= base_url($pres['thumbnail']) ?>" alt="Card image cap">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"> <b> <?= $pres['nama'] ?> </b></h4> <br>
                            <?= getKategoriPrestasi($pres['kategori'], true) ?>
                            <?= getTingkatPrestasi($pres['tingkat'], true) ?>
                            <p class="card-text"><?= $pres['deskripsi'] ?></p>
                            <div class="action">
                                <a href="<?= route_to('prestasi_detail', $pres['id']) ?>" class="btn btn-sm btn-primary">Detail</a>

                                <?php if (session()->get('level') == 'admin') : ?>
                                    <a href="<?= route_to('prestasi_edit', $pres['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <!-- <a onclick="deletePrestasi(this)" data-url="<?= route_to('prestasi_destroy', $pres['id']) ?>" class="btn btn-sm btn-danger">Hapus</a> -->
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-horizontal">
                    <div class="card-body">
                        <div class="text-center">
                            <table class="table">
                                <tr>
                                    <td><strong>Tidak Ada Data</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="link">
        <?= $pager->links('default', 'bs4') ?>
    </div>
</div>

<?= $this->section('scripts') ?>
<?= $this->include('prestasi/confirm_del') ?>
<?= $this->endSection() ?>