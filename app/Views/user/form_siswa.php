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
        <?= form_label('NIS', 'nis') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nis',
            'id' => 'nis',
            'value' => set_value('nis') == false && isset($user) ? $user['nis'] : set_value('nis'),
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
        <?= form_label('Tanggal Lahir', 'tglLahir') ?>
        <?= form_input([
            'type' => 'date',
            'name' => 'tanggal_lahir',
            'id' => 'tglLahir',
            'value' => set_value('tanggal_lahir') == false && isset($user) ? $user['tanggal_lahir'] : set_value('tanggal_lahir'),
            'class' => 'form-control'
        ]) ?>
    </div>
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
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Orang Tua', 'idOrtu') ?>
        <select name="id_ortu" id="idOrtu" class="form-control">
            <?php  
                $selected = set_value('id_ortu') == false && isset($user) ? $user['id_ortu'] : set_value('id_ortu');
            ?>
            <?php foreach($ortu as $or): ?>
                <option value="<?= $or['id'] ?>" <?= $selected == $or['id'] ? 'selected' : '' ?> ><?= $or['nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Status', 'statusUser') ?>
        <?= form_dropdown(
                'status',
                ['nonaktif' => 'nonaktif', 'aktif' => 'aktif'],
                set_value('status') == false && isset($user) ? $user['status'] : set_value('status'),
                ['class' => 'form-control', 'id' => 'statusUser']
            );
        ?>
    </div>
</div>
