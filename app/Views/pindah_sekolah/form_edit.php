<?php if ($tipe == 'masuk') : ?>
    <div class="row">
        <div class="col-12 col-md-6 pb-3 pb-md-0">
            <?= form_label('Nama', 'namaUser') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'nama',
                'id' => 'namaUser',
                'value' => set_value('nama') == false && isset($siswa) ? $siswa['nama'] : set_value('nama'),
                'class' => 'form-control'
            ]) ?>
        </div>
        <div class="col-12 col-md-6 pb-3 pb-md-0">
            <?= form_label('NIS', 'nis') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'nis',
                'id' => 'nis',
                'value' => set_value('nis') == false && isset($siswa) ? $siswa['nis'] : set_value('nis'),
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
<?php else : ?>
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
<?php endif; ?>
<hr>
<?= $this->include('pindah_sekolah/form_general') ?>