<div class="row">
    <?php if ($hari != null) : ?>

        <?php foreach ($hari as $hr) : ?>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <strong>
                            <h4><?= $hr->hari; ?></h4>
                        </strong>
                    </div>
                    <div class="card-body">
                        <table id="kelasTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <td>Pelajaran</td>
                                    <td>Jam</td>
                                    <td>Kelas</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($jadwal) > 0) : ?>
                                    <?php foreach ($jadwal as  $value) : ?>
                                        <?php if ($hr->hari == $value->hari) : ?>
                                            <tr>
                                                <input type="hidden" name="id" value="<?= $value->id; ?>">
                                                <input type="hidden" name="id_kelas" value="<?= $value->id_kelas; ?>">
                                                <input type="hidden" name="id_tahun_ajar" value="<?= $value->id_tahun_ajar; ?>">
                                                <td data-mapel="<?= $value->id_mapel; ?>" class="nama-mapel"><?= $value->nama_mapel ?></td>
                                                <td class="jam"><?= \Carbon\Carbon::parse($value->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($value->jam_selesai)->format('H:i') ?></td>
                                                <td data-guru="<?= $value->id_guru; ?>" class="nama-guru"><?= "$value->jengjang_kelas" .
                                                                                                                "$value->kode_kelas"; ?></td>
                                                <td> <a href="<?= route_to('panel_wali_absensi', $value->id_kelas, $value->id_tahun_ajar, $value->id); ?>" class="btn btn-info btn-absen">Absen</a> </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center"> Tidak Ada Data </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    <?php else : ?>
        <tr>
            <td colspan="5" class="text-center"> Tidak Ada Data </td>
        </tr>
    <?php endif; ?>
</div>
<div class="row">
    <div class="col-md-10">
        <!-- Modal -->
        <div class="modal fade" id="modal_absen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        // 'value' => $id_siswa
                    ]); ?>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nama</td>
                                    <td>Hadir</td>
                                    <td>Tidak hadir</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($absen as $key => $value) : ?>
                                    <tr>
                                        <td><?= $value['siswa_nama']; ?></td>
                                        <td><?= form_input([
                                                'type' => 'checkbox',
                                                'name' => 'hadir',
                                                'id' => 'hadir',
                                                'value' => 'hadir',
                                                'class' => 'form-check-input'
                                            ]); ?>
                                        </td>
                                        <td><?= form_input([
                                                'type' => 'checkbox',
                                                'name' => 'tidak_hadir',
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
<?= $this->section('scripts'); ?>
<script>

</script>
<?= $this->endSection(); ?>