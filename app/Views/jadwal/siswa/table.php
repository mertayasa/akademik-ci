<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php if (session()->get('level') == 'admin') : ?>
                    <a href="<?= route_to('jadwal_create') ?>" class="btn btn-primary btn-sm float-right">Tambah Jadwal</a>
                <?php endif; ?>
                <table>
                    <tr>
                        <td>Kelas</td>
                        <td class="px-2">:</td>
                        <td><?= convertRoman($anggota_kelas['jenjang']).''.$anggota_kelas['kode'] ?></td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td class="px-2">:</td>
                        <td><?= $wali_kelas ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Ajaran</td>
                        <td class="px-2">:</td>
                        <td><?= $anggota_kelas['tahun_mulai'].'/'.$anggota_kelas['tahun_selesai'] ?> </td>
                    </tr>
                </table>
            </div>
            <div class="card-body">

                <table id="kelasTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Pelajaran</td>
                            <td>Guru</td>
                            <td>Hari</td>
                            <td>Jam</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($jadwal) > 0): ?>
                            <?php
                                $index = 1;
                            ?>
                            <?php foreach ($jadwal as $key => $value):?>
                                <tr>
                                    <td><?= $index++ ?></td>
                                    <td><?= $value['nama_mapel'] ?></td>
                                    <td><?= $value['nama_guru'] ?></td>
                                    <td><?= $value['hari'] ?></td>
                                    <td><?= \Carbon\Carbon::parse($value['jam_mulai'])->format('H:i').' - '.\Carbon\Carbon::parse($value['jam_selesai'])->format('H:i') ?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center"> Tidak Ada Data </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>