<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        Tahun Ajar <?= $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] ?>
                    </div>
                    <div class="col-md-6">
                        <?php if (session()->get('level') == 'admin') : ?>
                            <a href="<?= route_to('kelas_create') ?>" class="btn btn-primary btn-sm float-right">Tambah Kelas</a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <div class="card-body">

                <table id="kelasDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Kelas</td>
                            <td>Kode</td>
                            <?php if (session()->get('level') == 'admin') : ?>
                                <td>Aksi</td>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script type="text/javascript">
    const table = $('#kelasDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('kelas_datatables') ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [
            {
                "targets": [0, 3],
                "orderable": false,
            },
            {
                "targets": [0, 2],
                "className": 'text-center',
            }
        ],
    })
</script>
<?= $this->endSection() ?>
