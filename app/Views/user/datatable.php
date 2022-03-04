<!-- Content -->
<!-- <?= $level ?> -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?php if (isAdmin()) : ?>
                <div class="card-header">
                    <a href="<?= route_to('user_create', $level) ?>" class="btn btn-primary btn-sm float-right">Tambah <?= $level == 'ortu' ? 'Orang Tua' : ucfirst($level) ?></a>
                </div>
            <?php endif; ?>
            <div class="card-body">

                <table id="userDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Avatar</td>
                            <td>Nama</td>
                            <?php switch ($level):
                                case 'admin': ?>
                                    <td>Email</td>
                                    <td>NIP</td>
                                    <td>No Telp</td>
                                    <td>Alamat</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'siswa': ?>
                                    <td>Kelas</td>
                                    <td>NIS</td>
                                    <td>Tahun ajar</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'guru': ?>
                                    <td>Email</td>
                                    <td>NIP</td>
                                    <td>No Telp</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'kepsek': ?>
                                    <td>Email</td>
                                    <td>NIP</td>
                                    <td>No Telp</td>
                                    <td>Masa Jabatan</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'ortu': ?>
                                    <td>Email</td>
                                    <td>No Telp</td>
                                    <td>Status Aktif</td>
                                    <?php break; ?>
                            <?php endswitch; ?>
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
    <?php if ($level == 'admin') : ?>
        const table = $('#userDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= route_to('user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [{
                "targets": [0, 1, 3, 5, 6, 7, -1],
                "orderable": false,
            }],
        })
    <?php elseif ($level == 'ortu') : ?>
        const table = $('#userDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= route_to('user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [{
                "targets": [0, 1, 3, 4, 5, -1],
                "orderable": false,
            }],
        })
    <?php elseif ($level == 'kepsek') : ?>
        const table = $('#userDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= route_to('user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [{
                "targets": [0, 1, 3, 5, 6, 7, -1],
                "orderable": false,
            }],
        })
    <?php else : ?>
        const table = $('#userDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= route_to('user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [{
                "targets": [0, 1, 3, 5, 6, -1],
                "orderable": false,
            }],
        })
    <?php endif; ?>

    function setNonaktif(url, tableId, user) {
        console.log(tableId)
        Swal.fire({
            title: "Warning",
            text: `Yakin menonkatifkan  ${user} ini? Proses ini tidak dapat diulang kembali`,
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
                        "_token": "2710f6ef480a1556820c350e89aa4fab"
                    },
                    "method": "get",
                    success: function(data) {
                        console.log(data)
                        showToast(data.code, data.message)

                        $('#' + tableId).DataTable().ajax.reload();
                    }
                })
            }
        })
    }
</script>

<?= $this->endSection() ?>