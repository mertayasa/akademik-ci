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
    <div class="col-12 col-md-3 pb-3 pb-md-0">
        <?= form_label('Level', 'level') ?>
        <?= form_dropdown(
                'level',
                ['admin' => 'Admin', 'kepsek' => 'Kepsek'],
                set_value('level') == false && isset($mapel) ? $mapel['level'] : set_value('level'),
                ['class' => 'form-control', 'id' => 'statusGuru']
            );
        ?>
    </div>
</div>
