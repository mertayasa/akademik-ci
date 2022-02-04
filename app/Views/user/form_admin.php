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
        <?= form_label('Foto Profil', 'filePondUpload') ?> <br>
        <?= form_upload([
            'type' => 'file',
            'name' => 'foto',
            'id' => 'filePondUpload',
            'data-foto' => isset($user) ? base_url($user['foto']) : ''
        ]) ?>
        <?= $this->include('layouts/filepond') ?>
    </div>