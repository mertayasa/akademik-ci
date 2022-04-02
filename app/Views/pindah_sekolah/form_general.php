<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tahun Ajar', 'tahunAjar') ?>
        <select name="id_tahun_ajar" id="tahunAjar" class="form-control">
            <?php
            $selected = set_value('id_tahun_ajar') == false && isset($pindah_sekolah) ? $pindah_sekolah['id_tahun_ajar'] : set_value('id_tahun_ajar');
            ?>
            <?php foreach ($tahun_ajar as $or) : ?>
                <option value="<?= $or['id'] ?>" <?= $selected == $or['id'] ? 'selected' : '' ?>><?= $or['tahun_mulai'] . '/' . $or['tahun_selesai'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php if ($tipe == 'keluar') : ?>
        <div class="col-12 col-md-6 pb-3 pb-md-0">
            <?= form_label('Tujuan Sekolah', 'tujuanSekolah') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'tujuan',
                'id' => 'tujuanSekolah',
                'placeholder' => 'Tujuan sekolah kepindahan',
                'value' => set_value('tujuan') == false && isset($pindah_sekolah) ? $pindah_sekolah['tujuan'] : set_value('tujuan'),
                'class' => 'form-control'
            ]) ?>
        </div>
    <?php else : ?>
        <div class="col-12 col-md-6 pb-3 pb-md-0">
            <?= form_label('Asal Sekolah', 'asalSekolah') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'asal',
                'id' => 'asalSekolah',
                'placeholder' => 'Asal sekolah kepindahan',
                'value' => set_value('asal') == false && isset($pindah_sekolah) ? $pindah_sekolah['asal'] : set_value('asal'),
                'class' => 'form-control'
            ]) ?>
        </div>
    <?php endif; ?>
</div>
<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Alasan pindah', 'alasanPindah') ?>
        <?= form_textarea([
            'type' => 'text',
            'name' => 'alasan',
            'id' => 'alasanPindah',
            'placeholder' => 'Alasan kepindahan',
            'value' => set_value('alasan') == false && isset($pindah_sekolah) ? $pindah_sekolah['alasan'] : set_value('alasan'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tanggal pindah', 'tanggalPindah') ?>
        <input type="date" name="tanggal" required value="<?= set_value('tanggal') == false && isset($pindah_sekolah) ? $pindah_sekolah['tanggal'] : set_value('tanggal') ?>" class="form-control" id="tanggalPindah">
    </div>
</div>
<hr>
<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Nama Orang Tua', 'nama_ortu') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nama_ortu',
            'id' => 'nama_ortu',
            'placeholder' => 'Nama Orang Tua',
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Nomer telepon Orang Tua', 'nomer_ortu') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nomer_ortu',
            'id' => 'nomer_ortu',
            'placeholder' => 'Nomer Telepon Orang Tua',
            'class' => 'form-control'
        ]) ?>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Email', 'email_ortu') ?>
        <?= form_input([
            'type' => 'email',
            'name' => 'email_ortu',
            'id' => 'email_ortu',
            'placeholder' => 'Email',
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Password', 'password_ortu') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'password_ortu',
            'id' => 'password_ortu',
            'placeholder' => 'Password',
            'class' => 'form-control'
        ]) ?>
    </div>
</div>