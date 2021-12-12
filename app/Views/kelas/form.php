<?= csrf_field() ?>
<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Jenjang Kelas (1-6)', 'jenjangKelas') ?>
        <?= form_dropdown(
                'jenjang',
                $jenjang,
                set_value('jenjang') == false && isset($jenjang_kelas) ? $jenjang_kelas['jenjang'] : set_value('jenjang'),
                ['class' => 'form-control', 'id' => 'jenjangKelas']
            );
        ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Kode Kelas', 'kodeKelas') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'kode',
            'id' => 'kodeKelas',
            'placeholder' => 'Kode kelas dapat berupa satu abjad A,B,C, dll',
            'value' => set_value('kode') == false && isset($jenjang_kelas) ? $jenjang_kelas['kode'] : set_value('kode'),
            'class' => 'form-control'
        ]) ?>
    </div>
</div>