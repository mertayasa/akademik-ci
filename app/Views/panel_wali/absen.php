<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?= form_open(route_to('insert_absen')); ?>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <th>Nama</th>
                        <th>Tanggalx</th>
                        <th>Absensi</th>
                    </thead>
                    <tbody>
                        <?php foreach ($absen as $key => $value) : ?>
                            <tr>

                                <td><?= $value['siswa_nama']; ?></td>
                                <td><?= date('d-m-Y'); ?></td>
                                <td>
                                    <div class="form-group">
                                        <select class="form-control" name="absensi" id="absensi">
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
    </div>
</div>