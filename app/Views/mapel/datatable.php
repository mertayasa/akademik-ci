<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php if (session()->get('level') == 'admin') : ?>
                    <a href="<?= route_to('mapel_create') ?>" class="btn btn-primary btn-sm float-right">Tambah Mata Pelajaran</a>
                <?php endif; ?>
            </div>
            <div class="card-body">

                <table id="mapelDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Status</td>
                            <td>Kelas Yang Menggunakan</td>
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
    const table = $('#mapelDataTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('mapel_datatables') ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [{
            "targets": [0, 2, 3, 4],
            "orderable": false,
        }],
    })
</script>
<?= $this->endSection() ?>