<div class="row">
    <div class="col-md-12">
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="modal_input_nilai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <?= form_open(route_to('nilai_create')); ?>
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Nilai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container mt-2">
                        <?php form_open(route_to('create_nilai')); ?>
                        <?= csrf_field(); ?>
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-responsive align-items-center">
                                <thead>
                                    <tr class="text-center">
                                        <th style="padding-bottom:35px !important" rowspan="2">No</th>
                                        <th style="padding-bottom:35px !important" rowspan="2">Mapel</th>
                                        <th rowspan="1" colspan="4">Nilai</th>

                                    </tr>
                                    <tr class="text-center">
                                        <th>TUGAS</th>
                                        <th>PAS</th>
                                        <th>PAT</th>
                                        <th>ULANGAN HARIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if (count($mapel) > 0) : ?>
                                        <?php foreach ($mapel as $mp) : ?>
                                            <tr>
                                                <?= form_input([
                                                    'type' => 'hidden',
                                                    'name' => 'id_kelas[]',
                                                    'id' => 'id_kelas',
                                                    'value' => $anggota_kelas['id_kelas']
                                                ]); ?>
                                                <?= form_input([
                                                    'type' => 'hidden',
                                                    'name' => 'id_mapel[]',
                                                    'id' => 'id_mapel',
                                                    'value' => $mp['id_mapel']
                                                ]); ?>
                                                <?= form_input([
                                                    'type' => 'hidden',
                                                    'name' => 'id_anggota_kelas[]',
                                                    'id' => 'id_anggota_kelas',
                                                    'value' => $anggota_kelas['id']
                                                ]); ?>
                                                <td><?= $no; ?></td>
                                                <td><?= $mp["nama"]; ?></td>
                                                <td><?= form_input([
                                                        'type' => 'number',
                                                        'class' => 'col-md-12 number-only',
                                                        'name' => 'tugas[]',
                                                        'id' => 'tugas',
                                                        'value' => ''
                                                    ]); ?>
                                                </td>
                                                <td><?= form_input([
                                                        'type' => 'number',
                                                        'class' => 'col-md-12 number-only',
                                                        'name' => 'uts[]',
                                                        'id' => 'uts',
                                                        'value' => ''
                                                    ]); ?>
                                                </td>
                                                <td><?= form_input([
                                                        'type' => 'number',
                                                        'class' => 'col-md-12 number-only',
                                                        'name' => 'uas[]',
                                                        'id' => 'uas',
                                                        'value' => ''
                                                    ]); ?>
                                                </td>
                                                <td><?= form_input([
                                                        'type' => 'number',
                                                        'class' => 'col-md-12 number-only',
                                                        'name' => 'harian[]',
                                                        'id' => 'harian',
                                                        'value' => ''
                                                    ]); ?>
                                                </td>
                                                <?= form_input([
                                                    'type' => 'hidden',
                                                    'name' => 'semester',
                                                    'id' => 'semester',
                                                    'value' => $semester
                                                ]); ?>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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