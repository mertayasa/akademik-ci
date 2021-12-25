<div class="col-md-12">
    <div class="card">
        <div class="card-header">
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