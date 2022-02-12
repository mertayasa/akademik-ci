<?= csrf_field() ?>
<?= $this->include('user/form_auth') ?>
<hr>

<?= $this->include('user/form_siswa_general') ?>

<!-- <?php if(!str_contains('pindah', uri_string())): ?> -->
<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Orang Tua', 'idOrtu') ?>
        <select name="id_ortu" id="idOrtu" class="form-control">
            <?php
            $selected = set_value('id_ortu') == false && isset($user) ? $user['id_ortu'] : set_value('id_ortu');
            ?>
            <?php foreach ($ortu as $or) : ?>
                <option value="<?= $or['id'] ?>" <?= $selected == $or['id'] ? 'selected' : '' ?>><?= $or['nama'] ?></option>
            <?php endforeach; ?>
        </select>
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
    </div>
</div>

<?= $this->include('layouts/filepond') ?>

<!-- <?php endif; ?> -->