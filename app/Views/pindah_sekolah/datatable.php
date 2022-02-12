<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <?php if (session()->get('level') == 'admin') : ?>
                    <a href="<?= route_to('pindah_sekolah_create', $tipe) ?>" class="btn btn-primary btn-sm float-right">Tambah Data <?= ucfirst($tipe) ?></a>
                <?php endif; ?>
            </div>
            <div class="card-body">

                <table id="pindahSekolahTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Siswa</td>
                            <?php if($tipe == 'masuk'): ?>
                                <td>Asal Sekolah</td>
                            <?php endif; ?>
                            <?php if($tipe == 'keluar'): ?>
                                <td>Tujuan Sekolah</td>
                            <?php endif; ?>
                            <td>Tahun Ajar</td>
                            <td>Alasan</td>
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
    const table = $('#pindahSekolahTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('pindah_sekolah_datatables', $tipe) ?>",
            "type": "POST",
            "data": {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            },
        },
        "columnDefs": [{
            "targets": [0, <?php (session()->get('level') == 'admin') ? 3 : 0 ?>],
            "orderable": false,
        }],
    })
</script>
<?= $this->endSection() ?>