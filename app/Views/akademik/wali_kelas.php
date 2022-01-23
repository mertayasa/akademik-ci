<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <table class="table table-striped table-hover" id="table_wali">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Wali Kelas</th>
                            <th>NIP</th>
                            <?php if (session()->get('level') == 'admin') : ?>
                                <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($wali_kelas) > 0) : ?>
                            <?php foreach ($wali_kelas as $wali) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td class="wali-nama"><?= $wali->nama_guru; ?></td>
                                    <td class="wali-nip"><?= $wali->nip; ?></td>
                                    <?php if (session()->get('level') == 'admin') : ?>
                                        <td><button data-toggle="modal" data-target="#modal_wali" class="btn btn-sm btn-warning action-edit" data-id="<?= $wali->id; ?>" data-id_guru="<?= $wali->id_guru_wali; ?>">Edit </button>
                                            <a href="<?= route_to('akademik_destroy_wali', $wali->id, $wali->id_kelas, $wali->id_tahun_ajar); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus Data Ini?')">Hapus</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak Ada Data. <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_wali">Pilih Wali</button> untuk tambah wal kelas </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- Modal -->
        <div class="modal fade" id="modal_wali" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="<?= route_to('akademik_save_wali', $id_kelas, $id_tahun_ajar); ?>">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Pilih Wali Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="id" value="">
                                <label for="nama_guru">Wali Kelas</label>
                                <select class="form-control" id="nama_guru" name="nama_guru">
                                    <option class="guru_awal" value="">Pilih Wali Kelas</option>
                                    <?php foreach ($guru as $gr) : ?>
                                        <option value="<?= $gr->id; ?>"><?= $gr->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
<?= $this->section('scripts') ?>
<script>
    $('.action-edit').on('click', function() {
        var id = $(this).data('id');
        var id_wali = $(this).data('id_guru');
        var nama_wali = $(this).closest('tr').find('.wali-nama').html()
        $('[name="id"]').val(id);
        $('.guru_awal').val(id_wali)
        $('.guru_awal').html(nama_wali)
        $('.modal-title').html('Edit Wali')
        $('form').attr('action', "<?= route_to('akademik_update_wali', $id_kelas, $id_tahun_ajar); ?>")
    });
</script>
<?= $this->endSection() ?>