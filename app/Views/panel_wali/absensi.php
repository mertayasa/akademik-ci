<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Absensi Siswa</h5>
            </div>
            <div class="card-body">
                <?= form_open(route_to('panel_wali_insert_absensi')); ?>
                <?= csrf_field(); ?>
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
                    // 'value' => $id_siswa
                ]); ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Nama</td>
                            <td>Hadir</td>
                            <td>Tidak hadir</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absensi as $key => $value) : ?>
                            <tr>
                                <td><?= $value['siswa_nama']; ?></td>
                                <td><?= form_input([
                                        'type' => 'checkbox',
                                        'name' => 'hadir[]',
                                        'id' => 'hadir',
                                        'value' => 'hadir',
                                        'class' => 'form-check-input'
                                    ]); ?>
                                </td>
                                <td><?= form_input([
                                        'type' => 'checkbox',
                                        'name' => 'tidak_hadir[]',
                                        'id' => 'tidak_hadir',
                                        'value' => 'tidak hadir',
                                        'class' => 'form-check-input'
                                    ]); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">
                    Submit
                </button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>