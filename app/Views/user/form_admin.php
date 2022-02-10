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

<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0 mt-3">
        <?= form_label('Foto Profil', 'filePondUpload') ?> <br>
        <?= form_upload([
            'type' => 'file',
            'name' => 'foto',
            'id' => 'filePondUpload',
            'data-foto' => isset($user) ? base_url($user['foto']) : ''
        ]) ?>
        <?= $this->include('layouts/filepond') ?>
    </div>
</div>