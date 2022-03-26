<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Jadwal</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Hari</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if (count($jadwal) > 0) : ?>
                                <?php foreach ($jadwal as $jad) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $jad['hari'] ?></td>
                                        <td><?= $jad['jenjang_kelas'].$jad['kode_kelas'] ?></td>
                                        <td><?= $jad['nama_mapel'] ?></td>
                                        <td><?= \Carbon\Carbon::parse($jad['jam_mulai'])->format('H:i') . ' - ' . \Carbon\Carbon::parse($jad['jam_selesai'])->format('H:i') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Anda tidak memiliki jadwal mengajar</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>