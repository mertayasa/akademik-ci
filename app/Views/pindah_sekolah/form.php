<?= csrf_field() ?>
<?= $this->include('user/form_auth') ?>
<hr>
<?= $this->include('user/form_siswa_general') ?>
<hr>
<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tahun Ajar', 'tahunAjar') ?>
        <select name="id_tahun_ajar" id="tahunAjar" class="form-control">
            <?php
            $selected = set_value('id_tahun_ajar') == false && isset($pindah_sekolah) ? $pindah_sekolah['id_tahun_ajar'] : set_value('id_tahun_ajar');
            ?>
            <?php foreach ($tahun_ajar as $or) : ?>
                <option value="<?= $or['id'] ?>" <?= $selected == $or['id'] ? 'selected' : '' ?>><?= $or['tahun_mulai'].'/'.$or['tahun_selesai'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
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
        <input type="date" name="tanggal" required class="form-control" id="tanggalPindah">
    </div>
</div>