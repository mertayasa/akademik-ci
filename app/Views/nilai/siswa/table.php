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
                            <td>Rata-Rata</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sum_tugas = 0; 
                            $sum_uts = 0; 
                            $sum_uas = 0; 
                            $sum_akumulatif = 0; 
                        ?>
                        <?php if (isset($nilai) && count($nilai) > 0): ?>
                            <?php foreach ($nilai as $key => $value):?>
                                <tr>
                                    <td><?= $key+ $key++ ?></td>
                                    <td><?= $value['nama_mapel'] ?></td>
                                    <td><?= $value['tugas'] ?></td>
                                    <td><?= $value['uts'] ?></td>
                                    <td><?= $value['uas'] ?></td>
                                    <td><?= round(($value['tugas'] + $value['uts'] + $value['uas'])/3) ?></td>

                                    <?php 
                                        $sum_tugas = $sum_tugas + $value['tugas'];
                                        $sum_uts = $sum_uts + $value['uts']; 
                                        $sum_uas = $sum_uas + $value['uas']; 
                                        $sum_akumulatif = $sum_akumulatif + round(($value['tugas'] + $value['uts'] + $value['uas'])/3)
                                    ?>
                                </tr>
                            <?php endforeach;?>
                            <tr>
                                <td colspan="2" class="text-center"> <b>Total</b> </td>
                                <td><?= $sum_tugas ?></td>
                                <td><?= $sum_uts ?></td>
                                <td><?= $sum_uas ?></td>
                                <td><?= $sum_akumulatif ?></td>
                            </tr>
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