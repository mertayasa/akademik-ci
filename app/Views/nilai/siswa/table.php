<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php if (session()->get('level') == 'admin') : ?>
                    <a href="<?= route_to('nilai_create') ?>" class="btn btn-primary btn-sm float-right">Tambah nilai</a>
                <?php endif; ?>
                <table>
                    <tr>
                        <td>Kelas</td>
                        <td class="px-2">:</td>
                        <td><?= convertRoman($anggota_kelas['jenjang']).''.$anggota_kelas['kode'] ?></td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td class="px-2">:</td>
                        <td><?= $wali_kelas ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Ajaran</td>
                        <td class="px-2">:</td>
                        <td><?= $anggota_kelas['tahun_mulai'].'/'.$anggota_kelas['tahun_selesai'] ?> </td>
                    </tr>
                </table>
            </div>
            <div class="card-body">

                <table id="kelasTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Pelajaran</td>
                            <td>Tugas</td>
                            <td>UTS</td>
                            <td>UAS</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($nilai) && count($nilai) > 0): ?>
                            <?php foreach ($nilai as $key => $value):?>
                                <tr>
                                    <td><?= $key+ $key++ ?></td>
                                    <td><?= $value['nama_mapel'] ?></td>
                                    <td><?= $value['tugas'] ?></td>
                                    <td><?= $value['uts'] ?></td>
                                    <td><?= $value['uas'] ?></td>
                                    <td><?= $value['akumulatif'] ?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center"> Tidak Ada Data </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>