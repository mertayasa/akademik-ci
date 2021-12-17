<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Siswa</h4>
            </div>
            <div class="card-body">

                <table id="daftarSiswaDatatable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>NIS</td>
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
    const table = $('#daftarSiswaDatatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('siswa_datatables', $tahun_ajar['id'], $kelas['id']) ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [{
            "targets": [0, 2],
            "orderable": false,
        }],
    })
</script>
<?= $this->endSection() ?>