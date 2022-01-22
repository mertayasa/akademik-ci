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
                    <?= form_input([
                        'type' => 'hidden',
                        'name' => 'id_siswa',
                        'id' => 'id_siswa',
                        'value' => $id_siswa
                    ]); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_guru">MATA PELAJARAN</label>
                            <div class="mapel"></div>
                        </div>
                        <div class="form-group">
                            <?= form_label('TUGAS', 'tugas'); ?>
                            <?= form_input([
                                'type'  => 'number',
                                'name'  => 'tugas',
                                'id'    => 'tugas',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= form_label('PAS', 'uts'); ?>
                            <?= form_input([
                                'type'  => 'number',
                                'name'  => 'uts',
                                'id'    => 'uts',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= form_label('PAT', 'uas'); ?>
                            <?= form_input([
                                'type'  => 'number',
                                'name'  => 'uas',
                                'id'    => 'uas',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= form_label('ULANGAN HARIAN', 'harian'); ?>
                            <?= form_input([
                                'type'  => 'number',
                                'name'  => 'harian',
                                'id'    => 'harian',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <?= form_input([
                            'type'  => 'hidden',
                            'name'  => 'semester',
                            'id'    => 'semester',
                            'value' => $semester,
                            'class' => 'form-control'
                        ]); ?>
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