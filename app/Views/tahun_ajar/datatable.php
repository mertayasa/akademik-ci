<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="<?= route_to('tahun_ajar_create') ?>" class="btn btn-primary btn-sm float-right">Tambah Tahun Ajar</a>
            </div>
            <div class="card-body">

                <table id="tahunAjarDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Tahun Mulai</td>
                            <td>Tahun Selesai</td>
                            <td>Keterangan</td>
                            <td>Aksi</td>
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
    const table = $('#tahunAjarDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('tahun_ajar_datatables') ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [{
            "targets": [0, 4],
            "orderable": false,
        }],
    })
</script>
<?= $this->endSection() ?>