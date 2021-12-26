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
                        <?php if (session()->get('level') == "admin") : ?>
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
                                <?php if (session()->get('level') == "admin") : ?>
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
<div class="row">
    <div class="col-md-12">
        <!-- Modal -->
        <div class="modal fade" id="modal_edit_nilai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?= form_open(route_to('update_nilai')); ?>
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Nilai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?= form_input([
                        'type' => 'hidden',
                        'name' => 'id_nilai',
                        'id' => 'id_nilai',
                        'value' => ''
                    ]); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_guru">Mata Pelajaran</label>
                            <div class="mapel"></div>
                        </div>
                        <div class="form-group">
                            <?= form_label('tugas', 'tugas'); ?>
                            <?= form_input([
                                'type'  => 'number',
                                'name'  => 'tugas',
                                'id'    => 'tugas',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= form_label('UTS', 'uts'); ?>
                            <?= form_input([
                                'type'  => 'number',
                                'name'  => 'uts',
                                'id'    => 'uts',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= form_label('uas', 'uas'); ?>
                            <?= form_input([
                                'type'  => 'number',
                                'name'  => 'uas',
                                'id'    => 'uas',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
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