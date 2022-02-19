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
    <?php if (!isSiswa() and !isAdmin()) : ?>
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
    <?php endif; ?>
</div>

<?php if (isSiswa() or isOrtu()) : ?>
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
        <?php if (isAdmin()) : ?>
            <div class="col-12 col-md-6 pb-3 pb-md-0">
                <?= form_label('Foto Profil', 'filePondUpload') ?> <br>
                <?= form_upload([
                    'type' => 'file',
                    'name' => 'foto',
                    'id' => 'filePondUpload',
                    'data-foto' => isset($user) ? base_url($user['foto']) : ''
                ]) ?>
            </div>
            <?= $this->include('layouts/filepond') ?>
        <?php endif; ?>
        <?php if (!isSiswa()) : ?>
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
        <?php endif; ?>
    </div>

<?php endif; ?>

<?php if (isGuru()) : ?>
    <div class="row mt-3">
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
    </div>
<?php endif; ?>
<div class="col-12 col-md-6 pb-3 pb-md-0">
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

<?php if (isOrtu()) : ?>
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
<?php endif; ?>