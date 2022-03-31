<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <?php if (isset($history_nilai) && count($history_nilai) > 0) : ?>
            <?php foreach ($history_nilai as $key => $history) : ?>
                <div class="card">

                    <div class="card-header">
                        <table>
                            <tr>
                                <td>Kelas</td>
                                <td class="px-2">:</td>
                                <td><?= $history['kelas'] ?></td>
                            </tr>
                            <tr>
                                <td>Wali Kelas</td>
                                <td class="px-2">:</td>
                                <td><?= $history['wali_kelas'] ?></td>
                            </tr>
                            <tr>
                                <td>Tahun Ajar</td>
                                <td class="px-2">:</td>
                                <td><?= $history['tahun_ajar'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-body">

                        <table id="kelasTable" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <td style="width:50px">No</td>
                                    <td style="width:200px">Pelajaran</td>
                                    <td style="width:100px">TUGAS</td>
                                    <td style="width:100px">PAS</td>
                                    <td style="width:100px">PAT</td>
                                    <td style="width:100px">ULANGAN HARIAN</td>
                                    <td style="width:100px">Rata-Rata</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum_tugas = 0;
                                $sum_uts = 0;
                                $sum_uas = 0;
                                $sum_ulangan_harian = 0;
                                $sum_akumulatif = 0;
                                ?>
                                <?php if (isset($history['nilai']) && count($history['nilai']) > 0) : ?>
                                    <?php
                                    $index = 1;
                                    ?>
                                    <?php foreach ($history['nilai'] as $key => $value) : ?>
                                        <tr>
                                            <td><?= $index++ ?></td>
                                            <td><?= $value['nama_mapel'] ?></td>
                                            <td><?= $value['tugas'] ?></td>
                                            <td><?= $value['uts'] ?></td>
                                            <td><?= $value['uas'] ?></td>
                                            <td><?= $value['harian'] ?></td>
                                            <td><?= round(($value['tugas'] + $value['uts'] + $value['uas']) / 3) ?></td>

                                            <?php
                                            $sum_tugas = $sum_tugas + $value['tugas'];
                                            $sum_uts = $sum_uts + $value['uts'];
                                            $sum_uas = $sum_uas + $value['uas'];
                                            $sum_ulangan_harian = $sum_ulangan_harian + $value['harian'];
                                            $sum_akumulatif = $sum_akumulatif + round(($value['tugas'] + $value['uts'] + $value['uas']) / 3)
                                            ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="2" class="text-center"> <b>Total</b> </td>
                                        <td><?= $sum_tugas ?></td>
                                        <td><?= $sum_uts ?></td>
                                        <td><?= $sum_uas ?></td>
                                        <td><?= $sum_ulangan_harian ?></td>
                                        <td><?= $sum_akumulatif ?></td>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center"> Tidak Ada Data </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center"> Tidak Ada Data </td>
            </tr>
        <?php endif; ?>
    </div>
</div>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>