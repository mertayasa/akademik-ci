<div class="row">
    <div class="col-12 px-0">
        <div class="table-responsive">
            <!-- <h4>Semester genap</h4> -->
            <?php if (count($group_bulan_genap) > 0) : ?>
                <?php $key_genap = 1 ?>
                <?php foreach ($group_bulan_genap as $group_key => $group_genap) : ?>
                    <table class="table table-bordered mb-5">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle">No</th>
                                <th rowspan="2" width="5%" class="text-center align-middle">NIS</th>
                                <th rowspan="2" style="min-width:300px" class="text-center align-middle">Nama</th>
                                <th colspan="<?= $group_genap['count_absen'] ?>" class="text-center"><?= $group_genap['month_name'] ?></th>
                                <th colspan="3" class="text-center align-middle">Keterangan</th>
                                <th rowspan="2" class="text-center align-middle">Jml</th>
                            </tr>
                            <tr>
                                <?php if (count($absen_genap) == 0) : ?>
                                    <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                                <?php else : ?>
                                    <?php foreach ($absen_genap as $key_abs => $tgl_genap) : ?>
                                        <?php if (str_contains($tgl_genap['tanggal'], $group_key)) : ?>
                                            <td rowspan="2" class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_genap['tanggal'] ?>"><?= $key_genap++ ?></td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <td class="text-center"> <b> S </b></td>
                                <td class="text-center"> <b> I </b></td>
                                <td class="text-center"> <b> A </b></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($count_absen == 0) : ?>
                            <?php else : ?>
                                <?php $no = 0 ?>
                                <?php $no_from_1 = 1 ?>
                                <?php foreach ($absen as $key => $value) : ?>
                                    <tr>
                                        <td><?= $no_from_1++ ?></td>
                                        <td class="text-center"><?= $value['siswa_nis'] ?></td>
                                        <th class="text-left"><?= $value['siswa_nama'] ?></th>
                                        <?php if (count($absen_genap) == 0) : ?>
                                            <td class="text-center"></td>
                                        <?php else : ?>
                                            <?php
                                                $count_sakit = 0;
                                                $count_ijin = 0;
                                                $count_tanpa_ket = 0;
                                            ?>
                                            <?php foreach ($absen_genap as $key_abs => $tgl_genap) : ?>
                                                <?php if (str_contains($tgl_genap['tanggal'], $group_key)) : ?>
                                                    <?php
                                                        $status_absensi = getAbsensiByDate($tgl_genap, $value['anggota_kelas_id'], $value['kelas_id'], 'genap');
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
                                                    <td class="text-center px-1"><?= $status_absensi ?></td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <td class="text-center"> <b> <?= $count_sakit == 0 ? '-' : $count_sakit ?> </b> </td>
                                        <td class="text-center"> <b> <?= $count_ijin == 0 ? '-' : $count_ijin ?> </b> </td>
                                        <td class="text-center"> <b> <?= $count_tanpa_ket == 0 ? '-' : $count_tanpa_ket ?> </b> </td>
                                        <td class="text-center"> <b> <?= ($count_tanpa_ket + $count_ijin + $count_sakit) == 0 ? '-' : ($count_tanpa_ket + $count_ijin + $count_sakit) ?> </b> </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                    <?php $key_genap = 1 ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">Belum ada absensi</p>
            <?php endif; ?>
        </div>
    </div>
</div>