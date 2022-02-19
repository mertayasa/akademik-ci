<div class="row">
    <div class="col-12 pr-2">
        <div class="table-responsive">
            <h4>Semester Ganjil</h4>
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th rowspan="3" width="12%" class="text-center align-middle">Bulan</th>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="<?= $max_absen_ganjil ?>">Pertemuan</td>
                        <td colspan="3" class="text-center">Keterangan</td>
                        <th rowspan="2" class="text-center align-middle">Jml</th>
                    </tr>
                    <tr>
                        <?php if (count($absen_ganjil) == 0) : ?>
                            <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                        <?php else : ?>
                            <?php for($i=1; $i<=$max_absen_ganjil; $i++) : ?>
                                    <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;"><?= $i ?></td>
                            <?php endfor; ?>
                        <?php endif; ?>
                        <td class="text-center"> <b> S </b></td>
                        <td class="text-center"> <b> I </b></td>
                        <td class="text-center"> <b> A </b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($group_bulan_ganjil) > 0) : ?>
                        <?php foreach ($group_bulan_ganjil as $group_key => $group_ganjil) : ?>
                            <tr>
                                <?php foreach ($absen as $key => $value) : ?>

                                    <?php
                                        $count_sakit = 0;
                                        $count_ijin = 0;
                                        $count_tanpa_ket = 0;
                                    ?>

                                    <td><?= $group_ganjil['month_name'] ?></td>
                                    <?php $count_blank = $max_absen_ganjil ?>
                                    <?php foreach ($absen_ganjil as $key_abs => $tgl_ganjil) : ?>
                                        <?php if (str_contains($tgl_ganjil['tanggal'], $group_key)) : ?>
                                            <?php
                                                $status_absensi = getAbsensiByDate($tgl_ganjil, $value['anggota_kelas_id'], $value['kelas_id']);
                                            ?>
                                            <?php
                                                if($status_absensi == 'S'){
                                                    $count_sakit++;
                                                }
                                                if($status_absensi == 'I'){
                                                    $count_ijin++;
                                                }
                                                if($status_absensi == 'A'){
                                                    $count_tanpa_ket++;
                                                }
                                            ?>
                                            <?php $count_blank = $count_blank - 1 ?>
                                            <td class="text-center px-1"><?= $status_absensi ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php for($i=1; $i<=$count_blank; $i++) : ?>
                                        <td class="text-center"> - </td>
                                    <?php endfor; ?>
                                    <td class="text-center"> <b> <?= $count_sakit == 0 ? '-' : $count_sakit ?> </b> </td>
                                    <td class="text-center"> <b> <?= $count_ijin == 0 ? '-' : $count_ijin ?> </b> </td>
                                    <td class="text-center"> <b> <?= $count_tanpa_ket == 0 ? '-' : $count_tanpa_ket ?> </b> </td>
                                    <td class="text-center"> <b> <?= ($count_tanpa_ket + $count_ijin + $count_sakit) == 0 ? '-' : ($count_tanpa_ket + $count_ijin + $count_sakit) ?> </b> </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-center">Belum ada absensi</p>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 pr-2 mt-5">
        <div class="table-responsive">
            <h4>Semester Genap</h4>
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th rowspan="3" width="12%" class="text-center align-middle">Bulan</th>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="<?= $max_absen_genap ?>">Pertemuan</td>
                        <td colspan="3" class="text-center">Keterangan</td>
                        <th rowspan="2" class="text-center align-middle">Jml</th>
                    </tr>
                    <tr>
                        <?php if (count($absen_genap) == 0) : ?>
                            <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                        <?php else : ?>
                            <?php for($i=1; $i<=$max_absen_genap; $i++) : ?>
                                    <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;"><?= $i ?></td>
                            <?php endfor; ?>
                        <?php endif; ?>
                        <td class="text-center"> <b> S </b></td>
                        <td class="text-center"> <b> I </b></td>
                        <td class="text-center"> <b> A </b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($group_bulan_genap) > 0) : ?>
                        <?php foreach ($group_bulan_genap as $group_key => $group_genap) : ?>
                            <tr>
                                <?php foreach ($absen as $key => $value) : ?>

                                    <?php
                                        $count_sakit = 0;
                                        $count_ijin = 0;
                                        $count_tanpa_ket = 0;
                                    ?>

                                    <td><?= $group_genap['month_name'] ?></td>
                                    <?php $count_blank = $max_absen_genap ?>
                                    <?php foreach ($absen_genap as $key_abs => $tgl_genap) : ?>
                                        <?php if (str_contains($tgl_genap['tanggal'], $group_key)) : ?>
                                            <?php
                                                $status_absensi = getAbsensiByDate($tgl_genap, $value['anggota_kelas_id'], $value['kelas_id']);
                                            ?>
                                            <?php
                                                if($status_absensi == 'S'){
                                                    $count_sakit++;
                                                }
                                                if($status_absensi == 'I'){
                                                    $count_ijin++;
                                                }
                                                if($status_absensi == 'A'){
                                                    $count_tanpa_ket++;
                                                }
                                            ?>
                                            <?php $count_blank = $count_blank - 1 ?>
                                            <td class="text-center px-1"><?= $status_absensi ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php for($i=1; $i<=$count_blank; $i++) : ?>
                                        <td class="text-center"> - </td>
                                    <?php endfor; ?>
                                    <td class="text-center"> <b> <?= $count_sakit == 0 ? '-' : $count_sakit ?> </b> </td>
                                    <td class="text-center"> <b> <?= $count_ijin == 0 ? '-' : $count_ijin ?> </b> </td>
                                    <td class="text-center"> <b> <?= $count_tanpa_ket == 0 ? '-' : $count_tanpa_ket ?> </b> </td>
                                    <td class="text-center"> <b> <?= ($count_tanpa_ket + $count_ijin + $count_sakit) == 0 ? '-' : ($count_tanpa_ket + $count_ijin + $count_sakit) ?> </b> </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-center">Belum ada absensi</p>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>