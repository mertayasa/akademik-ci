<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tahun Mulai', 'tahunMulai') ?>
        <?= form_input([
            'type' => 'number',
            'name' => 'tahun_mulai',
            'id' => 'tahunMulai',
            'value' => set_value('tahun_mulai') == false && isset($tahun_ajar) ? $tahun_ajar['tahun_mulai'] : set_value('tahun_mulai'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tahun Akhir', 'tahunAkhir') ?>
        <?= form_input([
            'type' => 'tahun_akhir',
            'name' => 'tahun_akhir',
            'id' => 'tahunAkhir',
            'value' => set_value('tahun_akhir') == false && isset($user) ? $user['tahun_akhir'] : set_value('tahun_akhir'),
            'class' => 'form-control'
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Keterangan', 'keterangan') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'keterangan',
            'id' => 'keterangan',
            'value' => set_value('keterangan') == false && isset($user) ? $user['keterangan'] : set_value('keterangan'),
            'class' => 'form-control'
        ]) ?>
    </div>
</div>