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
                                                <td> </td>
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