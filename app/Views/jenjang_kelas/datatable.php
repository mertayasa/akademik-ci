<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="<?= route_to('jenjang_kelas_create') ?>" class="btn btn-primary btn-sm float-right">Tambah Jenjang Kelas</a>
            </div>
            <div class="card-body">

                <table id="jenjangKelasDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Kelas</td>
                            <td>Kode</td>
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
    const table = $('#jenjangKelasDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('jenjang_kelas_datatables') ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [{
            "targets": [0, 3],
            "orderable": false,
        }],
    })
</script>
<?= $this->endSection() ?>