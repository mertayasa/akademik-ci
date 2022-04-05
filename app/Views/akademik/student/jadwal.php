<!-- Content -->
<div class="row mb-3">
    <div class="col-md-12">
        <?php if (session()->get('level') == 'admin') : ?>
            <button data-target="#modal_create_jadwal" data-toggle="modal" class="btn btn-primary btn-sm float-right">Tambah Jadwal</button>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <?php foreach ($hari as $hr) : ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <strong>
                        <h4><?= $hr->hari; ?></h4>
                    </strong>
                </div>
                <div class="card-body">
                    <table id="kelasTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td>Pelajaran</td>
                                <td>Guru</td>
                                <td>Jam</td>
                                <?php if (session()->get('level') == 'admin') : ?>
                                    <td>Action</td>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($jadwal) > 0) : ?>
                                <?php foreach ($jadwal as $key =>  $value) : ?>
                                    <?php if ($hr->hari == $value->hari) : ?>
                                        <tr>
                                            <input type="hidden" name="id" value="<?= $value->id; ?>">
                                            <input type="hidden" name="id_kelas" value="<?= $value->id_kelas; ?>">
                                            <input type="hidden" name="id_tahun_ajar" value="<?= $value->id_tahun_ajar; ?>">
                                            <td data-mapel="<?= $value->id_mapel; ?>" class="nama-mapel"><?= $value->nama_mapel ?></td>
                                            <td data-guru="<?= $value->id_guru; ?>" class="nama-guru"><?= $value->nama_guru ?></td>
                                            <td class="jam"><?= \Carbon\Carbon::parse($value->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($value->jam_selesai)->format('H:i') ?></td>
                                            <?php if (session()->get('level') == 'admin') : ?>
                                                <td class="td-action">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                                            Menu
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item action-edit" href="#" data-toggle="modal" data-target="#modal_edit">Edit</a>
                                                            <a class="dropdown-item action-hapus" href="<?= route_to('akademik_delete_schedule', $value->id, $value->id_kelas, $value->id_tahun_ajar); ?>" data-id="<?= $value->id_mapel; ?>" onclick="return confirm('Hapus data Ini?')">Hapus</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="display: none;"><textarea name="jadwal_data" id="jadwal_data"><?= json_encode($jadwal[$key]); ?></textarea></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center"> Tidak Ada Data </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- Modal -->
        <div class="modal fade" id="modal_edit" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="<?= route_to('akademik_update_schedule'); ?>">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_jadwal" value="">
                            <input type="hidden" name="id_kelas_post" value="">
                            <input type="hidden" name="id_tahun_ajar_post" value="">
                            <div class="form-group">
                                <label for="nama_mapel">Mata Pelajaran</label>
                                <select class="form-control" id="nama_mapel" name="nama_mapel">
                                    <option class="mapel_awal" value=""></option>
                                    <?php foreach ($mapel as $mp) : ?>
                                        <option value="<?= $mp['id']; ?>"><?= $mp['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_guru">Guru</label>
                                <select class="form-control" id="nama_guru" name="nama_guru">
                                    <option class="guru_awal" value=""></option>
                                    <?php foreach ($guru as $gr) : ?>
                                        <option value="<?= $gr->id; ?>"><?= $gr->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jam_mulai">Jam Mulai</label>
                                <input type="text" class="form-control" id="jam_mulai" name="jam_mulai">
                            </div>
                            <div class="form-group">
                                <label for="jam_selesai">Jam Selesai</label>
                                <input type="text" class="form-control" id="jam_selesai" name="jam_selesai">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (isAdmin()) : ?>
    <?= $this->include('includes/modal_create_jadwal'); ?>
<?php endif; ?>

<?= $this->section('scripts') ?>

<script>
    $('.action-edit').on('click', function(e) {
        // var nama_mapel = $(this).closest('tr').find('.nama-mapel').html()
        // var nama_guru = $(this).closest('tr').find('.nama-guru').html()
        // var id_mapel = $(this).closest('tr').find('.nama-mapel').data('mapel')
        // var id_guru = $(this).closest('tr').find('.nama-guru').data('guru')
        // var id_jadwal = $(this).closest('tr').find('[name="id"]').val()
        // var id_kelas = $(this).closest('tr').find('[name="id_kelas"]').val()
        // var id_tahun_ajar = $(this).closest('tr').find('[name="id_tahun_ajar"]').val()
        // // console.log(id_guru)
        var jam = $(this).closest('tr').find('.jam').html().split('-')
        var jam_mulai = jam[0];
        var jam_selesai = jam[1];

        var data = $(this).closest('tr').find('#jadwal_data').val();
        console.log(data)
        var json = JSON.parse(data);
        $('.mapel_awal').val(json.id_mapel)
        $('.mapel_awal').html(json.nama_mapel)
        $('.guru_awal').val(json.id_guru)
        $('.guru_awal').html(json.nama_guru)
        $('.guru_awal').attr('selected', true)
        $('.mapel_awal').attr('selected', true)
        $('[name="id_kelas_post"]').val(json.id_kelas)
        $('[name="id_tahun_ajar_post"]').val(json.id_tahun_ajar)
        $('[name="id_jadwal"]').val(json.id)
        $('#jam_mulai').val(jam_mulai)
        $('#jam_selesai').val(jam_selesai)

        $('#select2-nama_guru-container').attr('title', json.nama_guru)
        $('#select2-nama_guru-container').html(json.nama_guru)
        $('#select2-nama_mapel-container').attr('title', json.nama_mapel)
        $('#select2-nama_mapel-container').html(json.nama_mapel)

        $('#modal_edit').show()
    })
    $('.action-hapus').on('click', function() {
        var id_jadwal = $(this).closest('tr').find('[name="id"]').val()
        var id_kelas = $(this).closest('tr').find('[name="id_kelas"]').val()
        var id_tahun_ajar = $(this).closest('tr').find('[name="id_tahun_ajar"]').val()

        $('[name="id_kelas_post"]').val(id_kelas)
        $('[name="id_tahun_ajar_post"]').val(id_tahun_ajar)
        $('[name="id_jadwal"]').val(id_jadwal)
    })
</script>

<?= $this->endSection() ?>