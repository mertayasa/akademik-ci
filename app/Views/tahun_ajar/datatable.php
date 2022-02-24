<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php if (session()->get('level') == 'admin') : ?>
                    <a href="<?= route_to('tahun_ajar_create') ?>" class="btn btn-primary btn-sm float-right">Tambah Tahun Ajar</a>
                <?php endif; ?>
            </div>
            <div class="card-body">

                <table id="tahunAjarDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Tahun Ajar</td>
                            <td>Status</td>
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
    const table = $('#tahunAjarDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [2, 'DESC'],
        "ajax": {
            "url": "<?= route_to('tahun_ajar_datatables') ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [{
            "targets": [0, 2, 3],
            "orderable": false,
        }],
    })

    function setActive(url, tableId, prompt) {
        Swal.fire({
            title: "Warning",
            text: prompt,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#169b6b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    "url": url,
                    "dataType": "JSON",
                    "headers": {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    },
                    "method": "get",
                    success: function(data) {
                        showToast(data.code, data.message)
                        $('#' + tableId).DataTable().ajax.reload();
                    }
                })
            }
        })
    }
</script>
<?= $this->endSection() ?>