<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <table>
                <?php if (session()->get('level') == 'admin') : ?>
                    <tr>
                        <td>Nama Siswa</td>
                        <td class="px-2">:</td>
                        <td><?= $anggota_kelas['nama_anggota_kelas'] ?? '-' ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>Kelas</td>
                    <td class="px-2">:</td>
                    <!-- <td><?= isset($anggota_kelas) && count($anggota_kelas) != 0 ? convertRoman($anggota_kelas['jenjang']) . '' . $anggota_kelas['kode'] : '-' ?></td> -->
                    <td><?= isset($anggota_kelas) && count($anggota_kelas) != 0 ? $anggota_kelas['jenjang'] . '' . $anggota_kelas['kode'] : '-' ?></td>
                </tr>
                <tr>
                    <td>Wali Kelas</td>
                    <td class="px-2">:</td>
                    <td><?= $wali_kelas ?? '-' ?></td>
                </tr>
                <tr>
                    <td>Tahun Ajaran</td>
                    <td class="px-2">:</td>
                    <td><?= isset($anggota_kelas) && count($anggota_kelas) != 0 ? $anggota_kelas['tahun_mulai'] . '/' . $anggota_kelas['tahun_selesai'] : '-' ?> </td>
                </tr>
                <?php if (isset($semester)) : ?>
                    <tr>
                        <td>Semester</td>
                        <td class="px-2">:</td>
                        <td><?= ucwords($semester); ?> </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>