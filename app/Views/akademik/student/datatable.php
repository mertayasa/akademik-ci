<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Daftar Siswa</h4>
                    </div>
                    <div class="col-md-6">
                        <?php if (session()->get('level') == 'admin') : ?>
                            <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modal_insert_anggota">Tambah Anggota Kelas</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <table id="daftarSiswaDatatable" class="table table-striped table-hover">
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

            </div>

        </div>
    </div>
</div>
<?php if (session()->get('level') == 'admin') : ?>
    <?= $this->include('includes/modal_insert_anggota'); ?>
<?php endif; ?>

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
            "targets": [0, 2, 3, 4],
            "orderable": false,
        }],
    })

    function updateStatus(url, tableId, text) {
        Swal.fire({
            title: "Warning",
            text: text,
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
                        console.log(data)
                        showToast(data.code, data.message)
                        $('#' + tableId).DataTable().ajax.reload();
                    }
                })
            }
        })
    }
    $('#form_search_anggota').submit(function(e) {
        e.preventDefault()
        var data = $(this).serialize()
        var url = $(this).attr('action')
        $.ajax({
            url: url,
            data: data,
            method: 'get',
            success: function(response) {
                var result = JSON.parse(response)
                if (result != null) {
                    $(result).each(function(i, val) {
                        console.log(val)
                        $('#id_siswa').val(val.id_siswa)
                        $('#nama').html(val.nama)
                        $('#nis_siswa').html(val.nis)
                        $('#status').html(val.status)
                    })
                } else {
                    Swal.fire({
                        title: "Warning",
                        text: "Siswa tidak ditemukan",
                        icon: 'warning',
                    })
                }
            }
        })
    })

    $('#form_insert_anggota').submit(function(e) {
        e.preventDefault()
        console.log('sahsihai')
        var data = $(this).serialize()
        var url = $(this).attr('action')
        $.ajax({
            url: url,
            data: data,
            method: 'post',
            success: function(response) {
                var data = JSON.parse(response)
                console.log(response)
                if (data.code == 1) {
                    Swal.fire({
                        title: "Warning",
                        text: data.message,
                        icon: 'warning',
                    })
                } else {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                }
            }
        })
    })
</script>
<?= $this->endSection() ?>