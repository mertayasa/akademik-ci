<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="<?= route_to('agenda_create') ?>" class="btn btn-primary btn-sm float-right">Upload Agenda</a>
            </div>
            <div class="card-body">

                <table id="agendaDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td></td>
                            <td>Judul</td>
                            <td>Status</td>
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
    const table = $('#agendaDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('agenda_datatables') ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [{
                "targets": [0, 1, 3, 4],
                "orderable": false,
            },
            {
                "targets": [1],
                "visible": false,
            }
        ],
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