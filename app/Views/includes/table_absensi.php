<div class="row">
    <div class="col-12 px-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <td rowspan="3" class="text-center align-middle">No</td>
                        <td rowspan="3" class="text-center align-middle">Nama</td>
                        <td colspan="100" class="text-center">Absensi Ke-</td>
                    </tr>
                    <tr>
                        <td colspan="<?= count($absen_ganjil) ?>" class="text-center">Semester 1</td>
                        <td colspan="<?= count($absen_genap) ?>" class="text-center">Semester 2</td>
                    </tr>
                    <tr>
                        <?php if(count($absen_ganjil) == 0): ?>
                                <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                        <?php else : ?>
                            <?php $key_ganjil = 0 ?>
                            <?php foreach ($absen_ganjil as $key_abs => $tgl_ganjil) : ?>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_ganjil['tanggal'] ?>"><?= $key_ganjil = $key_abs+1 ?> <br> <small> <?= $tgl_ganjil['tanggal'] ?></small></td>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if(count($absen_genap) == 0): ?>
                                <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                        <?php else : ?>
                            <?php $key_genap = 0 ?>
                            <?php foreach ($absen_genap as $key_abs => $tgl_genap) : ?>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_genap['tanggal'] ?>"><?= $key_genap = $key_abs+1 ?> <br> <small> <?= $tgl_genap['tanggal'] ?></small></td>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                        <?php if($count_absen == 0): ?>
                        <?php else : ?>
                                <?php $no = 0 ?>
                                <?php foreach ($absen as $key => $value) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no = $no+1 ?></td>
                                        <th class="text-left"><?= $value['siswa_nama'] ?></th>
                                            <?php if(count($absen_ganjil) == 0): ?>
                                                <td class="text-center"></td>
                                            <?php else: ?>
                                                <?php foreach ($absen_ganjil as $key_abs => $tgl_ganjil) : ?>
                                                    <td class="text-center px-1"><?= getAbsensiByDate($tgl_ganjil, $value['anggota_kelas_id']) ?></td>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                            <?php if(count($absen_genap) == 0): ?>
                                                <td class="text-center"></td>
                                            <?php else: ?>
                                                <?php foreach ($absen_genap as $key_abs => $tgl) : ?>
                                                    <td class="text-center px-1"><?= getAbsensiByDate($tgl, $value['anggota_kelas_id']) ?></td>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>