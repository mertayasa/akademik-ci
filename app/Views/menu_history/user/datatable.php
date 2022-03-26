<!-- Content -->
<!-- <?= $level ?> -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <table id="userDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <!-- <td>Avatar</td> -->
                            <?php switch ($level):
                                case 'admin': ?>
                                    <td>NIP</td>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>No Telp</td>
                                    <td>Alamat</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'siswa': ?>
                                    <td>NIS</td>
                                    <td>Nama</td>
                                    <td>Kelas</td>
                                    <td>Tahun ajar</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'guru': ?>
                                    <td>NIP</td>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>No Telp</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'kepsek': ?>
                                    <td>NIP</td>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>No Telp</td>
                                    <td>Masa Jabatan</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'ortu': ?>
                                    <td>Nama</td>
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
                "url": "<?= route_to('history_user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [
                {
                    "targets": [0, 1, 3, 5, 6, 7, -1],
                    "orderable": false,
                },
                {
                    "targets": [0, 1],
                    "className": 'text-center',
                }
            ],
        })
    <?php elseif ($level == 'ortu') : ?>
        const table = $('#userDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= route_to('history_user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [
                {
                    "targets": [0, 1, 3, 4, 5, -1],
                    "orderable": false,
                },
                {
                    "targets": [0],
                    "className": 'text-center',
                }
            ],
        })
    <?php elseif ($level == 'guru') : ?>
        const table = $('#userDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= route_to('history_user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [
                {
                    "targets": [0, 1, 3, 5, 6, -1],
                    "orderable": false,
                },
                {
                    "targets": [0, 1],
                    "className": 'text-center',
                }
            ],
        })
    <?php else : ?>
        const table = $('#userDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= route_to('history_user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [
                {
                    "targets": [0, 1, 3, 5, 6, -1],
                    "orderable": false,
                },
                {
                    "targets": [0, 1],
                    "className": 'text-center',
                }
            ],
        })
    <?php endif; ?>
</script>
<?= $this->endSection() ?>