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
                                    <td>NIS</td>
                                    <td>Kelas</td>
                                    <td>Tahun ajar</td>
                                    <td>Status Aktif</td>
                                <?php break;
                                case 'guru': ?>
                                    <td>Email</td>
                                    <td>NIP</td>
                                    <td>No Telp</td>
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
            "targets": [0, 4],
            "orderable": false,
        }],
    })
</script>
<?= $this->endSection() ?>