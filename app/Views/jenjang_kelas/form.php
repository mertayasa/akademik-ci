<?= csrf_field() ?>
<div class="row mt-3">
    <div class="col-12 col-md-3 pb-3 pb-md-0">
        <?= form_label('Level', 'level') ?>
        <?= form_dropdown(
                'level',
                $tahun_ajar,
                set_value('tahun_ajar_id') == false && isset($jenjang_kelas) ? $jenjang_kelas['tahun_ajar_id'] : set_value('tahun_ajar_id'),
                ['class' => 'form-control', 'id' => 'statusGuru']
            );
        ?>
    </div>
</div>