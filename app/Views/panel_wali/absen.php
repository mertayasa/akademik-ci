<div class="row">
    <div class="col-md-12">
        <?php if (count($absen) > 0) : ?>
            <?= form_open(route_to('panel_wali_insert_absensi')); ?>
            <div class="card">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-control col-4" name="semester" id="semester">
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Absensi</th>
                        </thead>
                        <tbody>
                            <?php foreach ($absen as $key => $value) : ?>
                                <tr>
                                    <?= form_input([
                                        'type' => 'hidden',
                                        'name' => 'id_anggota_kelas[]',
                                        'id' => 'id_anggota_kelas',
                                        'value' => $value['anggota_kelas_id']
                                    ]); ?>
                                    <?= form_input([
                                        'type' => 'hidden',
                                        'name' => 'id_kelas[]',
                                        'id' => 'id_kelas',
                                        'value' => $value['kelas_id']
                                    ]); ?>
                                    <td><?= $value['siswa_nama']; ?></td>
                                    <td><?= date('d-m-Y'); ?></td>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control" name="absensi[]" id="absensi">
                                                <option value="">--pilih absensi--</option>
                                                <option value="hadir">Hadir</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="tanpa keterangan">Tanpa Keterangan</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <?= form_close(); ?>
        <?php else : ?>
            <table class="table table-striped">
                <thead>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Absensi</th>
                </thead>
                <tbody>
                    <td colspan="3" class="text-center"><strong>Tidak Ada Data</strong></td>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>