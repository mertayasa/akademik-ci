<div class="col-md-12">
    <div class="card">
        <?php if (isset($nilai['ganjil'])) : ?>
            <div class="card-header">
                <h4>Nilai Semester Ganjil</h4>
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
                            <?php if (session()->get('level') == "admin" || session()->get('is_wali')) : ?>
                                <td style="width:100px">Action</td>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum_tugas = 0;
                        $sum_uts = 0;
                        $sum_uas = 0;
                        $sum_harian = 0;
                        $sum_akumulatif = 0;
                        $no = 1;
                        ?>
                        <?php if (isset($nilai['ganjil']) && count($nilai['ganjil']) > 0) : ?>
                            <?php foreach ($mapel as $key => $mp) : ?>
                                <?php

                                $nama_mapel = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['nama_mapel'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['nama_mapel'] : 0;
                                $nilai_tugas = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['tugas'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['tugas'] : 0;
                                $nilai_uts = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['uts'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['uts'] : 0;
                                $nilai_uas = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['uas'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['uas'] : 0;
                                $nilai_harian = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['harian'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['harian'] : 0;
                                $nilai_id_mapel = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['id_mapel'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['id_mapel'] : 0;

                                ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>
                                    <td><?= $mp['nama'] ?></td>
                                    <td class="text-right"><?= $nilai_tugas ?></td>
                                    <td class="text-right"><?= $nilai_uts ?></td>
                                    <td class="text-right"><?= $nilai_uas ?></td>
                                    <td class="text-right"><?= $nilai_harian ?></td>
                                    <td style="display: none;" class="id_mapel"><?= $mp['id_mapel'] ?></td>
                                    <td><?= round(($nilai_tugas + $nilai_uts + $nilai_uas + $nilai_harian) / 4) ?></td>
                                    <?php if (session()->get('level') == "admin" || session()->get('is_wali')) : ?>
                                        <td><button data-toggle="modal" data-target="#modal_edit_nilai" data-id_mapel="<?= $mp['id_mapel']; ?>" data-id="<?= (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['id_nilai'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'ganjil', $mp['id_mapel'])[0]['id_nilai'] : 0 ?>" class="btn btn-sm btn-warning action-edit">Edit </button></td>
                                    <?php endif; ?>


                                    <?php
                                    $sum_tugas = $sum_tugas + $nilai_tugas;
                                    $sum_uts = $sum_uts + $nilai_uts;
                                    $sum_uas = $sum_uas + $nilai_uas;
                                    $sum_harian = $sum_harian + $nilai_harian;
                                    $sum_akumulatif = $sum_akumulatif + round(($nilai_tugas + $nilai_uts + $nilai_uas + $nilai_harian) / 4)
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2" class="text-center"> <b>Total</b> </td>
                                <td class="text-right"><?= $sum_tugas ?></td>
                                <td class="text-right"><?= $sum_uts ?></td>
                                <td class="text-right"><?= $sum_uas ?></td>
                                <td class="text-right"><?= $sum_harian ?></td>
                                <td class="text-right"><?= $sum_akumulatif ?></td>
                            </tr>
                        <?php else : ?>
                            <?php if (session()->get('level') == 'admin') : ?>
                                <tr>
                                    <td colspan="7" class="text-center"> Tidak ada data / Nilai belum diinput </td>
                                    <td><button data-toggle="modal" data-target="#modal_input_nilai" class="btn btn-primary">Input Nilai</button></td>
                                </tr>
                            <?php else : ?>
                                <td colspan="8" class="text-center"> Tidak ada data / Nilai belum diinput </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        <?php endif; ?>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <?php if (isset($nilai['genap'])) : ?>
            <div class="card-header">
                <h4>Nilai Semester Genap</h4>
            </div>
            <div class="card-body">
                <table id="kelasTable" class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Pelajaran</td>
                            <td>TUGAS</td>
                            <td>PAS</td>
                            <td>PAT</td>
                            <td>ULANGAN HARIAN</td>
                            <td>Rata-Rata</td>
                            <?php if (session()->get('level') == "admin" || session()->get('is_wali')) : ?>
                                <td>Action</td>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum_tugas = 0;
                        $sum_uts = 0;
                        $sum_uas = 0;
                        $sum_harian = 0;
                        $sum_akumulatif = 0;
                        $no = 1;
                        ?>
                        <?php if (isset($nilai['genap']) && count($nilai['genap']) > 0) : ?>
                            <?php foreach ($mapel as $key => $mp) : ?>
                                <?php

                                $nama_mapel = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['nama_mapel'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['nama_mapel'] : 0;
                                $nilai_tugas = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['tugas'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['tugas'] : 0;
                                $nilai_uts = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['uts'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['uts'] : 0;
                                $nilai_uas = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['uas'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['uas'] : 0;
                                $nilai_harian = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['harian'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['harian'] : 0;
                                $nilai_id_mapel = (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['id_mapel'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['id_mapel'] : 0;

                                ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $mp['nama'] ?></td>
                                    <td><?= $nilai_tugas ?></td>
                                    <td><?= $nilai_uts ?></td>
                                    <td><?= $nilai_uas ?></td>
                                    <td><?= $nilai_harian ?></td>
                                    <td style="display: none;" class="id_mapel"><?= $mp['id_mapel'] ?></td>
                                    <td><?= round(($nilai_tugas + $nilai_uts + $nilai_uas + $nilai_harian) / 4) ?></td>
                                    <?php if (session()->get('level') == "admin" || session()->get('is_wali')) : ?>
                                        <td><button data-toggle="modal" data-target="#modal_edit_nilai" data-id_mapel="<?= $mp['id_mapel']; ?>" data-id="<?= (isset(getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['id_nilai'])) ? getNilaiByJadwal($anggota_kelas['id_kelas'], $anggota_kelas['id'], 'genap', $mp['id_mapel'])[0]['id_nilai'] : 0 ?>" class="btn btn-sm btn-warning action-edit">Edit </button></td>
                                    <?php endif; ?>


                                    <?php
                                    $sum_tugas = $sum_tugas + $nilai_tugas;
                                    $sum_uts = $sum_uts + $nilai_uts;
                                    $sum_uas = $sum_uas + $nilai_uas;
                                    $sum_harian = $sum_harian + $nilai_harian;
                                    $sum_akumulatif = $sum_akumulatif + round(($nilai_tugas + $nilai_uts + $nilai_uas + $nilai_harian) / 4)
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2" class="text-center"> <b>Total</b> </td>
                                <td><?= $sum_tugas ?></td>
                                <td><?= $sum_uts ?></td>
                                <td><?= $sum_uas ?></td>
                                <td><?= $sum_harian ?></td>
                                <td><?= $sum_akumulatif ?></td>
                            </tr>
                        <?php else : ?>
                            <?php if (session()->get('level') == 'admin') : ?>
                                <tr>
                                    <td colspan="7" class="text-center"> Tidak ada data / Nilai belum diinput </td>
                                    <td><button data-toggle="modal" data-target="#modal_input_nilai" class="btn btn-primary">Input Nilai</button></td>
                                </tr>
                            <?php else : ?>
                                <td colspan="8" class="text-center"> Tidak ada data / Nilai belum diinput </td>
                            <?php endif; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php if (session()->get('level') == 'admin' || session()->get('is_wali')) : ?>
    <?= $this->include('includes/modal_edit_nilai'); ?>
<?php endif; ?>
<?php if (count($nilai) <= 0) : ?>
    <?php if (session()->get('level') == 'admin') : ?>
        <?= $this->include('includes/modal_input_nilai'); ?>
    <?php endif ?>
<?php endif; ?>

<?= $this->section('scripts') ?>
<script>
    $('.action-edit').on('click', function() {
        var mapel = $(this).closest('tr').find('td').eq(1).html();
        var tugas = $(this).closest('tr').find('td').eq(2).html();
        var uts = $(this).closest('tr').find('td').eq(3).html();
        var uas = $(this).closest('tr').find('td').eq(4).html();
        var harian = $(this).closest('tr').find('td').eq(5).html();
        var id_nilai = $(this).data('id')

        $('.mapel').html(mapel)
        $('#id_nilai').val(id_nilai)
        $('#tugas').val(tugas)
        $('#uts').val(uts)
        $('#uas').val(uas)
        $('#harian').val(harian)
    })
</script>
<?= $this->endSection() ?>