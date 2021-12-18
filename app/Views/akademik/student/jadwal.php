<!-- Content -->
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
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($jadwal) > 0) : ?>
                                <?php foreach ($jadwal as  $value) : ?>
                                    <tr>
                                        <td><?= $value->nama_mapel ?></td>
                                        <td><?= $value->nama_guru ?></td>
                                        <td><?= \Carbon\Carbon::parse($value->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($value->jam_selesai)->format('H:i') ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                                    Menu
                                                </a>

                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item action-edit" href="#">Edit</a>
                                                    <a class="dropdown-item action-hapus" href="#">Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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

<?= $this->section('scripts') ?>

<script>
    $('.action-edit').on('click', function() {
        // console.log('edit')

    })
</script>

<?= $this->endSection() ?>