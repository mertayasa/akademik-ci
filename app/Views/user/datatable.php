<!-- Content -->
<!-- <?= $level ?> -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?php if (isAdmin()) : ?>
                <div class="card-header">
                    <!-- <div class="float-left"> -->
                    <div class="row">
                        <?php if ($level == 'siswa' or $level == 'guru') : ?>
                            <div class="col-8 d-flex">
                                <?php if ($level == 'siswa') : ?>
                                    <div class="col-3">
                                        <form id="filter" method="get">
                                            <?= form_label('Tahun Ajar', 'tahun_ajar') ?>
                                            <div class="form-group">
                                                <select class="form-control" name="id_tahun_ajar" id="filterTahunAjar">
                                                    <option value="">Pilih Tahun Ajar</option>
                                                    <?php foreach ($tahun_ajar as $data) : ?>
                                                        <option value="<?= $data['id']; ?>"><?= $data['tahun_mulai'] . ' - ' . $data['tahun_selesai']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-3">
                                        <?= form_label('Kelas', 'kelas') ?>
                                        <div class="form-group">
                                            <select class="form-control" name="kelas" id="filterKelas">
                                                <option value="">Pilih Kelas</option>
                                                <?php foreach ($kelas as $data) : ?>
                                                    <option value="<?= $data['id']; ?>"><?= $data['jenjang'] . ' ' . $data['kode']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <?= form_label('Status', 'status') ?>
                                        <div class="form-group">
                                            <select class="form-control" name="status" id="filterStatus">
                                                <option value="">Pilih Status</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="nonaktif">Nonaktif</option>
                                                <option value="lulus">Lulus</option>
                                            </select>

                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($level == 'guru') : ?>
                                    <div class="col-3">
                                        <form id="filter" method="get">
                                            <?= form_label('Status', 'status') ?>
                                            <div class="form-group">
                                                <select class="form-control" name="status" id="filterStatus">
                                                    <option value="">Pilih Status</option>
                                                    <option value="aktif">Aktif</option>
                                                    <option value="nonaktif">Nonaktif</option>
                                                </select>
                                            </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-3" style="padding-top: 31px;">
                                    <button class="btn btn-success" type="submit" id="btn_filter_submit">Filter</button>
                                </div>
                                </form>
                            </div>
                            <div class="col-4 style=" style="padding-top: 31px;">
                                <a href="<?= route_to('user_create', $level) ?>" class="btn btn-primary float-right">Tambah <?= $level == 'ortu' ? 'Orang Tua' : ucfirst($level) ?></a>
                            </div>
                        <?php else : ?>
                            <div class="col-12">
                                <a href="<?= route_to('user_create', $level) ?>" class="btn btn-primary float-right btn-sm">Tambah <?= $level == 'ortu' ? 'Orang Tua' : ucfirst($level) ?></a>
                            </div>
                        <?php endif; ?>

                    </div>
                    <!-- </div> -->
                </div>
            <?php endif; ?>
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
                                    <!-- <td>Status Aktif</td> -->
                                <?php break;
                                case 'siswa': ?>
                                    <td>NIS</td>
                                    <td>Nama</td>
                                    <td>Kelas</td>
                                    <td>Tahun ajar</td>
                                    <!-- <td>Status Aktif</td> -->
                                <?php break;
                                case 'guru': ?>
                                    <?php if (isAdmin() or isGuru()) : ?>
                                        <td>NIP</td>
                                    <?php else : ?>
                                        <td></td>
                                    <?php endif; ?>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>No Telp</td>
                                    <!-- <td>Status Aktif</td> -->
                                <?php break;
                                case 'kepsek': ?>
                                    <td>NIP</td>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>No Telp</td>
                                    <td>Masa Jabatan</td>
                                    <!-- <td>Status Aktif</td> -->
                                <?php break;
                                case 'ortu': ?>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>No Telp</td>
                                    <!-- <td>Status Aktif</td> -->
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
                    "targets": [0, 1, 3, 5, 6, -1],
                    "orderable": false,
                },
                {
                    "targets": [0, 1, 4],
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
                "url": "<?= route_to('user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [{
                    "targets": [0, 2, 3, 4, -1],
                    "orderable": false,
                },
                {
                    "targets": [0],
                    "className": 'text-center',
                }
            ],
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
    <?php elseif ($level == 'guru') : ?>
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
                    "targets": [0, 1, 3, 5, -1],
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
                "url": "<?= route_to('user_datatables', $level) ?>",
                "type": "POST",
                "data": {
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
            },
            "columnDefs": [{
                    "targets": [0, 1, 3, 5, -1],
                    "orderable": false,
                },
                {
                    "targets": [0, 1, 3, 4],
                    "className": 'text-center',
                }
            ],
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

<script>
    $('#filter').submit(function(e) {
        e.preventDefault()
        const form = $(this)
        const data = form.serialize()
        const url = "<?= route_to('user_datatables_get', $level) ?>"
        $('#userDataTable').DataTable().ajax.url(url + `?${data}`).load();
    })

    // console.log(url + `?${data}`);
    // let filterTahunAjar = $('#filterTahunAjar')
    // let filterKelas = $('#filterKelas')
    // let filterStatus = $('#filterStatus')

    // console.log(filterKelas.val());
    // if(filterTahunAjar.val() == '' && filterKelas.val() == '' && filterStatus.val() == ''){
    //     console.log('asdsad');
    //     $('#userDataTable').DataTable().ajax.reload()
    // }else{
    // }
</script>

<?= $this->endSection() ?>