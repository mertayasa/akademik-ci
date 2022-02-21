<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php if (isset($no_tahun_selected)) : ?>
                    <table class="table table-hover">
                        <tr>
                            <td class="text-center"><strong> Pilih Tahun Ajar Terlebih Dahulu</strong></td>
                        </tr>
                    </table>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script type="text/javascript">
</script>
<?= $this->endSection() ?>