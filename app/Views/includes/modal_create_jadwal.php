<div class="row">
    <div class="col-md-12">
        <!-- Modal -->
        <div class="modal fade" id="modal_create_jadwal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?= form_open(route_to('jadwal_create')); ?>
                    <?= csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Jadwal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?= form_input([
                        'type' => 'hidden',
                        'name' => 'id_kelas',
                        'id' => 'id_kelas',
                        'value' => $uri->getSegment(2)
                    ]); ?>
                    <?= form_input([
                        'type' => 'hidden',
                        'name' => 'id_tahun_ajar',
                        'id' => 'id_tahun_ajar',
                        'value' => $uri->getSegment(3)
                    ]); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_mapel">Nama Mapel</label>
                            <select class="form-control" name="id_mapel" id="id_mapel">
                                <?php foreach ($mapel as $value) : ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_guru">Nama guru</label>
                            <select class="form-control" name="id_guru" id="id_guru">
                                <?php foreach ($guru as $value) : ?>
                                    <option value="<?= $value->id; ?>"><?= $value->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <?= form_label('Hari', 'hari'); ?>
                            <select class="form-control" name="hari" id="hari">
                                <?php foreach ($hari_all as $value) : ?>
                                    <option value="<?= $value; ?>"><?= $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?= form_label('Jam Mulai', 'jam_mulai'); ?>
                            <?= form_input([
                                'type'  => 'text',
                                'name'  => 'jam_mulai',
                                'id'    => 'jam_mulai',
                                'value' => '',
                                'class' => 'form-control'
                            ]); ?>
                        </div>
                        <div class="form-group">
                            <?= form_label('Jam Selesai', 'jam_selesai'); ?>
                            <?= form_input([
                                'type'  => 'text',
                                'name'  => 'jam_selesai',
                                'id'    => 'jam_selesai',
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