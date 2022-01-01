<div class="col-md-12">
    <div class="card">
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
                    $sum_akumulatif = 0;
                    ?>
                    <?php if (isset($nilai) && count($nilai) > 0) : ?>
                        <?php foreach ($nilai as $key => $value) : ?>
                            <tr>
                                <td><?= $key + $key++ ?></td>
                                <td><?= $value['nama_mapel'] ?></td>
                                <td><?= $value['tugas'] ?></td>
                                <td><?= $value['uts'] ?></td>
                                <td><?= $value['uas'] ?></td>
                                <td><?= round(($value['tugas'] + $value['uts'] + $value['uas']) / 3) ?></td>
                                <?php if (session()->get('level') == "admin" || session()->get('is_wali')) : ?>
                                    <td><button data-toggle="modal" data-target="#modal_edit_nilai" data-id="<?= $value["id_nilai"]; ?>" class="btn btn-sm btn-warning action-edit">Edit </button></td>
                                <?php endif; ?>

                                <?php
                                $sum_tugas = $sum_tugas + $value['tugas'];
                                $sum_uts = $sum_uts + $value['uts'];
                                $sum_uas = $sum_uas + $value['uas'];
                                $sum_akumulatif = $sum_akumulatif + round(($value['tugas'] + $value['uts'] + $value['uas']) / 3)
                                ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2" class="text-center"> <b>Total</b> </td>
                            <td><?= $sum_tugas ?></td>
                            <td><?= $sum_uts ?></td>
                            <td><?= $sum_uas ?></td>
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
</div>
<?php if (session()->get('level') == 'admin' || session()->get('is_wali')) : ?>
    <?= $this->include('includes/modal_edit_nilai'); ?>
<?php endif; ?>

<?= $this->section('scripts') ?>
<script>
    $('.action-edit').on('click', function() {
        var mapel = $(this).closest('tr').find('td').eq(1).html();
        var tugas = $(this).closest('tr').find('td').eq(2).html();
        var uts = $(this).closest('tr').find('td').eq(3).html();
        var uas = $(this).closest('tr').find('td').eq(4).html();
        var id_nilai = $(this).data('id')

        $('.mapel').html(mapel)
        $('#id_nilai').val(id_nilai)
        $('#tugas').val(tugas)
        $('#uts').val(uts)
        $('#uas').val(uas)
    })
</script>
<?= $this->endSection() ?>