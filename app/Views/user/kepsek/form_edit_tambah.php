<?= csrf_field() ?>
<?= $this->include('user/form_auth') ?>
<hr>

<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Nama', 'namaUser') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nama',
            'id' => 'namaUser',
            'value' => set_value('nama') == false && isset($user) ? $user['nama'] : set_value('nama'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('No Telpon', 'noTelp') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'no_telp',
            'id' => 'noTelp',
            'value' => set_value('no_telp') == false && isset($user) ? $user['no_telp'] : set_value('no_telp'),
            'class' => 'form-control'
        ]) ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('NIP', 'nip') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nip',
            'id' => 'nip',
            'value' => set_value('nip') == false && isset($user) ? $user['nip'] : set_value('nip'),
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Alamat', 'alamat') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'alamat',
            'id' => 'alamat',
            'value' => set_value('alamat') == false && isset($user) ? $user['alamat'] : set_value('alamat'),
            'class' => 'form-control'
        ]) ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tempat Lahir', 'tempatLahir') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'tempat_lahir',
            'id' => 'tempatLahir',
            'value' => set_value('tempat_lahir') == false && isset($user) ? $user['tempat_lahir'] : set_value('tempat_lahir'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Status', 'statusUser') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'status',
            'id' => 'status',
            'value' => 'aktif',
            'class' => 'form-control',
            'disabled' => TRUE
        ]); ?>
    </div>
</div>

<?php if (isAdmin()) : ?>
    <div class="row mt-3">
        <div class="col-12 col-md-6 pb-3 pb-md-0">
            <?= form_label('Masa Jabatan', 'masa_jabatan_kepsek') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'masa_jabatan_kepsek',
                'id' => 'masa_jabatan_kepsek',
                'value' => set_value('masa_jabatan_kepsek') == false && isset($user) ? $user['masa_jabatan_kepsek'] : set_value('masa_jabatan_kepsek'),
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
<?php endif; ?>

<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Bio', 'bio') ?>
        <?= form_textarea([
            'type' => 'text',
            'name' => 'bio',
            'id' => 'bio',
            'value' => set_value('bio') == false && isset($user) ? $user['bio'] : set_value('bio'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <div class="mt-3">
            <?= form_label('Foto Profil', 'filePondUpload') ?> <br>
            <?= form_upload([
                'type' => 'file',
                'name' => 'foto',
                'id' => 'filePondUpload',
                'data-foto' => isset($user) ? base_url($user['foto']) : ''
            ]) ?>
        </div>
        <?= $this->include('layouts/filepond') ?>
        <small><sup>*</sup> <i>Gambar yang diupload maksimal berukuran 5MB</i></small><br>
    </div>
</div>