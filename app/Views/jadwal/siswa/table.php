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
                        <td><?= isset($anggota_kelas) ? convertRoman($anggota_kelas['jenjang']).''.$anggota_kelas['kode'] : '-' ?></td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td class="px-2">:</td>
                        <td><?= $wali_kelas ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Ajaran</td>
                        <td class="px-2">:</td>
                        <td><?= isset($anggota_kelas) ? $anggota_kelas['tahun_mulai'].'/'.$anggota_kelas['tahun_selesai'] : '-' ?> </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?= $this->include('jadwal/card'); ?>
</div>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>