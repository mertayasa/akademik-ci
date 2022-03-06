<<<<<<< HEAD
<!-- <div class="info-siswa">
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
</div> -->
<hr>
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
<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tanggal Lahir', 'tglLahir') ?>
        <?= form_input([
            'type' => 'date',
            'name' => 'tanggal_lahir',
            'id' => 'tglLahir',
            'value' => set_value('tanggal_lahir') == false && isset($siswa) ? $siswa['tanggal_lahir'] : set_value('tanggal_lahir'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tempat Lahir', 'tempatLahir') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'tempat_lahir',
            'id' => 'tempatLahir',
            'value' => set_value('tempat_lahir') == false && isset($siswa) ? $siswa['tempat_lahir'] : set_value('tempat_lahir'),
            'class' => 'form-control'
        ]) ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Angkatan', 'angkatan') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'angkatan',
            'id' => 'angkatan',
            'value' => set_value('angkatan') == false && isset($siswa) ? $siswa['angkatan'] : set_value('angkatan'),
            'class' => 'form-control number-only'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Status', 'statusUser') ?>
        <?php if (isset($siswa['is_pindah_keluar']) && $siswa['is_pindah_keluar']) : ?>
            <input type="text" name="status" class="form-control" disabled id="" value="Nonaktif">
            <span class="text-danger">Siswa telah pindah sekolah, tidak bisa mengubah status</span>
        <?php else : ?>
            <?= form_dropdown(
                'status',
                ['nonaktif' => 'nonaktif', 'aktif' => 'aktif'],
                set_value('status') == false && isset($siswa) ? $siswa['status'] : set_value('status'),
                ['class' => 'form-control', 'id' => 'statusUser']
            );
            ?>
        <?php endif; ?>
    </div>
</div>
=======
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
>>>>>>> cebce2132a4b24d22e7cb22283ca6b200e7536a0
<hr>
<?= $this->include('pindah_sekolah/form_general') ?>