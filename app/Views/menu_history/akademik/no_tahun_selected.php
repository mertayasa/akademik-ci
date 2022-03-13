<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?= form_open(route_to('history_data_index', 'akademik'), ['method' => 'get', 'id' => 'storeForm']); ?>
                <div class="row align-items-end">
                    <div class="col-12 col-md-3 pb-3 pb-md-0">
                        <?= form_label('Filter Tahun Ajar', 'tahunAjar') ?>
                        <?= form_dropdown(
                            'id_tahun',
                            $tahun_ajar,
                            set_value('tahun_ajar_selected') == false && isset($id_tahun_selected) ? $id_tahun_selected : set_value('tahun_ajar_selected'),
                            ['class' => 'form-control', 'id' => 'tahunAjar']
                        );
                        ?>
                    </div>
                    <div class="col-12 col-md-3 pb-3 pb-md-0">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="card-body">
                <?php if (isset($no_tahun_selected)) : ?>
                    <table class="table table-hover">
                        <tr>
                            <td class="text-center"><strong> Pilih Tahun Ajar Terlebih Dahulu</strong></td>
                        </tr>
                    </table>
                <?php else : ?>
                    <?= $this->include('menu_history/akademik/list_kelas') ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script type="text/javascript">
</script>
<?= $this->endSection() ?>