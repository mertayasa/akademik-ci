<div class="info-siswa">
    <table>
        <tr>
            <th>Nama</th>
            <td class="px-3">:</td>
            <td><?= $siswa['nama'] ?></td>
        </tr>
        <tr>
            <th>NIS</th>
            <td class="px-3">:</td>
            <td><?= $siswa['nis'] ?>
        </td>
    </table>
</div>
<hr>
<?= $this->include('pindah_sekolah/form_general') ?>