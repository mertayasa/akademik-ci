<div class="row">
    <div class="col-12 col-md-6 pr-2">
        <div class="table-responsive">
            <h4>Semester Ganjil</h4>
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th rowspan="2" width="5%" class="text-center align-middle">No</th>
                        <th colspan="100" class="text-center">Absensi Ke-</th>
                    </tr>
                    <tr>
                        <td class="text-center" >Tanggal Absensi</td>
                        <td class="text-center" >Status Kehadiran</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($absen_ganjil) == 0) : ?>
                        <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title=""></td>
                        <td class="text-center" colspan="2" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                    <?php else : ?>
                        <?php $key_ganjil = 0 ?>
                        <?php foreach ($absen_ganjil as $key_abs => $tgl_ganjil) : ?>
                            <tr>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" ><?= $key_ganjil = $key_abs + 1 ?></td>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_ganjil['tanggal'] ?>"><small> <?= $tgl_ganjil['tanggal'] ?></small></td>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_ganjil['tanggal'] ?>"><?= getAbsensiByDate($tgl_ganjil['tanggal'], $anggota_kelas['id'], $anggota_kelas['id_kelas']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12 col-md-6 pl-2">
        <div class="table-responsive">
            <h4>Semester Genap</h4>
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th rowspan="2" width="5%" class="text-center align-middle">No</th>
                        <th colspan="100" class="text-center">Absensi Ke-</th>
                    </tr>
                    <tr>
                        <td class="text-center" >Tanggal Absensi</td>
                        <td class="text-center" >Status Kehadiran</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($absen_genap) == 0) : ?>
                        <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title=""></td>
                        <td class="text-center" colspan="2" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                    <?php else : ?>
                        <?php $key_genap = 0 ?>
                        <?php foreach ($absen_genap as $key_abs => $tgl_genap) : ?>
                            <tr>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" ><?= $key_genap = $key_abs + 1 ?></td>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_genap['tanggal'] ?>"><?= $key_genap = $key_abs + 1 ?> <br> <small> <?= $tgl_genap['tanggal'] ?></small></td>
                                <td class="text-center px-1" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_genap['tanggal'] ?>"><?= getAbsensiByDate($tgl_genap['tanggal'], $anggota_kelas['id'], $anggota_kelas['id_kelas']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>