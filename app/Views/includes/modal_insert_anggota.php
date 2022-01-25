<div class="row">
    <div class="col-md-12">
        <!-- Modal -->
        <div class="modal fade" id="modal_insert_anggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Input Nilai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container mt-2">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <?= form_open(route_to('akademik_search_anggota_kelas'), ['method' => 'get', 'class' => 'form-inline', 'id' => 'form_search_anggota']); ?>
                                <?= csrf_field(); ?>
                                <?= form_label('NIS: ', 'nis'); ?>
                                <?= form_input([
                                    'type' => 'number',
                                    'class' => 'form-control',
                                    'name' => 'nis',
                                    'id' => 'nis',
                                    'value' => ''
                                ]); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                <?= form_close(); ?>
                            </div>
                        </div>
                        <hr>

                        <form action="<?= route_to('akademik_add_anggota_kelas', $kelas['id'], $tahun_ajar['id']); ?>" id="form_insert_anggota" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <?= form_input([
                                        'type' => 'hidden',
                                        'name' => 'id_tahun_ajar',
                                        'id' => 'id_tahun_ajar',
                                        'value' => $tahun_ajar['id']
                                    ]); ?>
                                    <?= form_input([
                                        'type' => 'hidden',
                                        'name' => 'id_kelas',
                                        'id' => 'id_kelas',
                                        'value' => $kelas['id']
                                    ]); ?>
                                    <?= form_input([
                                        'type' => 'hidden',
                                        'class' => 'form-control',
                                        'name' => 'id_siswa',
                                        'id' => 'id_siswa',
                                        'value' => ''
                                    ]); ?>
                                    <?= form_label('Nama: ', 'nama'); ?>
                                    <div id="nama"></div>
                                    <br>
                                    <?= form_label('NIS: ', 'nis_siswa'); ?>
                                    <div id="nis_siswa"></div>
                                    <br>
                                    <?= form_label('Status: ', 'status'); ?>
                                    <div id="status"></div>
                                    <br>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>