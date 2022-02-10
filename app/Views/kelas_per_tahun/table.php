<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Tahun Ajar <?= $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] ?>
                <!-- <a href="<?= route_to('kelas_per_tahun_edit', $tahun_ajar['id']) ?>" class="btn btn-warning btn-sm float-right">Edit Kelas Aktif</a> -->
            </div>
            <div class="card-body">
                <table id="mapelDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td class="text-center">Status Aktif</td>
                        </tr>
                    </thead>
                    <?php $no = 1;
                    foreach ($all_kelas as $key => $kelas) : ?>
                        <tbody class="mb-5">
                            <tr>
                                <td colspan="4">  <b> Kelas <?= $key ?> </b></td>
                            </tr>
                            <?php foreach ($kelas as $kel) : ?>
                                <tr>
                                    <td><?= convertRoman($kel['jenjang']) . ' ' . $kel['kode'] ?></td>
                                    <td class="text-center">
                                        <div class="form-group mb-0">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1"></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    table tbody {
        border-bottom: 15px solid gray;
    }
</style>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>