<?= csrf_field() ?>
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
        <?= form_label('Pekerjaan', 'pekerjaan') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'pekerjaan',
            'id' => 'pekerjaan',
            'value' => set_value('pekerjaan') == false && isset($user) ? $user['pekerjaan'] : set_value('pekerjaan'),
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

<?= $this->include('user/form_auth') ?>