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
                        <?php if (isset($nilai['ganjil']) && count($nilai['ganjil']) > 0) : ?>
                            <?php foreach ($nilai['ganjil'] as $key => $value) : ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $value['nama_mapel'] ?></td>
                                    <td><?= $value['tugas'] ?></td>
                                    <td><?= $value['uts'] ?></td>
                                    <td><?= $value['uas'] ?></td>
                                    <td><?= $value['harian'] ?></td>
                                    <td><?= round(($value['tugas'] + $value['uts'] + $value['uas']) / 3) ?></td>
                                    <?php if (session()->get('level') == "admin" || session()->get('is_wali')) : ?>
                                        <td><button data-toggle="modal" data-target="#modal_edit_nilai" data-id="<?= $value["id_nilai"]; ?>" class="btn btn-sm btn-warning action-edit">Edit </button></td>
                                    <?php endif; ?>

                                    <?php
                                    $sum_tugas = $sum_tugas + $value['tugas'];
                                    $sum_uts = $sum_uts + $value['uts'];
                                    $sum_uas = $sum_uas + $value['uas'];
                                    $sum_harian = $sum_harian + $value['harian'];
                                    $sum_akumulatif = $sum_akumulatif + round(($value['tugas'] + $value['uts'] + $value['uas']) / 3)
                                    ?>
                                </tr>
                                <?php $no++ ?>
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
                            <?php foreach ($nilai['genap'] as $key => $value) : ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $value['nama_mapel'] ?></td>
                                    <td><?= $value['tugas'] ?></td>
                                    <td><?= $value['uts'] ?></td>
                                    <td><?= $value['uas'] ?></td>
                                    <td><?= $value['harian'] ?></td>
                                    <td><?= round(($value['tugas'] + $value['uts'] + $value['uas']) / 3) ?></td>
                                    <?php if (session()->get('level') == "admin" || session()->get('is_wali')) : ?>
                                        <td><button data-toggle="modal" data-target="#modal_edit_nilai" data-id="<?= $value["id_nilai"]; ?>" class="btn btn-sm btn-warning action-edit">Edit </button></td>
                                    <?php endif; ?>

                                    <?php
                                    $sum_tugas = $sum_tugas + $value['tugas'];
                                    $sum_uts = $sum_uts + $value['uts'];
                                    $sum_uas = $sum_uas + $value['uas'];
                                    $sum_harian = $sum_harian + $value['harian'];
                                    $sum_akumulatif = $sum_akumulatif + round(($value['tugas'] + $value['uts'] + $value['uas']) / 3)
                                    ?>
                                </tr>
                                <?php $no++ ?>
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