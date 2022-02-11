<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Nama', 'namaMapel') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nama',
            'id' => 'namaMapel',
            'value' => set_value('nama') == false && isset($mapel) ? $mapel['nama'] : set_value('nama'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Status', 'statusMapel') ?>
        <?= form_dropdown(
                'status',
                ['aktif' => 'Aktif', 'nonaktif' => 'Non Aktif'],
                set_value('status') == false && isset($mapel) ? $mapel['status'] : set_value('status'),
                ['class' => 'form-control']
            );
        ?>
    </div>
</div>
