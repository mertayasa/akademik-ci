<?php foreach ($kelas as $key_jenjang => $jenjang_kelas) : ?>

    <h5>Kelas <?= $key_jenjang ?></h5>

    <div class="row">
        <?php $count_kelas = 0 ?>
        <?php foreach ($jenjang_kelas['kelas'] as $as => $kode_kelas) : ?>

            <div class="col-12 col-md-3 mb-3 d-flex">
                <div class="card flex-fill" style="width: 16rem;">
                    <div class="over-image">
                        <div style="background-color: #95D1CC; height:130px" class="card-img-top"></div>
                        <!-- <div class="centered"><?= convertRoman($key_jenjang) . '' . $kode_kelas['kode'] ?></div> -->
                        <div class="centered"><?= $key_jenjang . '' . $kode_kelas['kode'] ?></div>
                    </div>
                    <div class="card-body px-2 py-2">
                        <table width="100%">
                            <tr style="vertical-align: top;">
                                <td width="35%">Siswa</td>
                                <td><?= $kode_kelas['jumlah_siswa'] ?? '0'  ?></td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td width="35%">Guru Wali</td>
                                <td><?= $kode_kelas['nama_guru'] ?? 'Guru Belum Ditentukan'  ?></td>
                            </tr>
                        </table>
                        <hr>
                        <a href="<?= route_to('history_akademik_show_student', $id_tahun_selected, $kode_kelas['id']) ?>" class="btn btn-sm btn-info">Siswa</a>
                        <a href="<?= route_to('history_akademik_schedule', $kode_kelas['id'], $id_tahun_selected); ?>" class="btn btn-sm btn-primary">Jadwal</a>
                        <a href="<?= route_to('history_akademik_wali', $kode_kelas['id'], $id_tahun_selected); ?>" class="btn btn-sm btn-warning">Wali</a>
                        <a href="<?= route_to('history_akademik_absensi', $kode_kelas['id'], $id_tahun_selected); ?>" class="btn btn-sm btn-secondary">Absensi</a>
                    </div>
                </div>
            </div>
            <?php $count_kelas++ ?>

        <?php endforeach; ?>

        <?php if ($count_kelas == 0) : ?>
            <div class="no-class pl-1">
                <p>Tidak ada kelas aktif untuk kelas <?= $key_jenjang ?></p>
            </div>
        <?php endif; ?>
    </div>

<?php endforeach; ?>

<style>
    /* over-image holding the image and the text */
    .over-image {
        position: relative;
        text-align: center;
        color: white;
    }

    /* Centered text */
    .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        font-weight: bold;
    }
</style>