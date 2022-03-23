<!-- Content -->

<div class="mt-3">
    <table id="daftarSiswaDatatable<?= $key ?>" class="table table-striped table-hover">
        <thead>
            <tr>
                <td>No</td>
                <td>NIS</td>
                <td>Nama</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<?= $this->section('scripts') ?>
<script type="text/javascript">
    $('#daftarSiswaDatatable<?= $key ?>').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [1, 'DESC'],
        "ajax": {
            "url": "<?= route_to('siswa_datatables', $tahun_ajar, $kelas) ?>",
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