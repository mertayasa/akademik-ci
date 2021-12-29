<!-- Content -->

<table id="daftarSiswaDatatable<?= rand(1231, 234234) ?>" class="table table-striped table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>NIS</td>
            <td>Status</td>
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<?= $this->section('scripts') ?>
<script type="text/javascript">
    // const table = $('#daftarSiswaDatatable<?= rand(1231, 234234) ?>').DataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     "order": [1, 'DESC'],
    //     "ajax": {
    //         "url": "<?= 'asd' //route_to('siswa_datatables', $id_tahun_ajar, $kel['id_kelas']) ?>",
    //         "type": "POST",
    //         "data": {
    //             "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
    //         },
    //     },
    //     "columnDefs": [{
    //         "targets": [0, 2],
    //         "orderable": false,
    //     }],
    // })
</script>
<?= $this->endSection() ?>