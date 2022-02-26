<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="main-body">

                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="<?= base_url($user['foto']) ?>" style="object-fit:cover" alt="Admin" class="rounded-circle border border-secondary" width="150" height="150">
                                            <div class="mt-3">
                                                <h4><?= $user['nama'] ?></h4>
                                                <p class="text-secondary mb-1"><?= ucfirst($level) ?></p>
                                                <?php if (session()->get('id') == $id and session()->get('level') == $level) : ?>
                                                    <a href="<?= route_to('profile_edit'); ?>" class="btn btn-warning mt-2">Edit Profil</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Informasi <?= ucfirst($level) ?> </h5>
                                    </div>
                                    <div class="card-body">

                                        <?php if ($level == 'guru' or $level == 'siswa') : ?>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0"><?= $level == 'guru' ? 'NIP' : 'NIS' ?></h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <?= ($level == 'guru' ? $user['nip'] : $user['nis']) ?? '-' ?>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endif; ?>
                                        <?php if (isset($level) and $level != 'siswa') : ?>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Email</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <?= $user['email'] ?? '-' ?>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endif; ?>

                                        <?php if ($level != 'admin' and $level != 'siswa') : ?>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">No Telpon</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <?= $user['no_telp'] ?? '-' ?>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endif; ?>

                                        <?php if ($level != 'admin' and $level != 'siswa') : ?>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Alamat</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <?= $user['alamat'] ?? '-' ?>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endif; ?>

                                        <?= $this->include('profile/show_include/' . $level . '.php'); ?>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Status Aktif</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= ucfirst($user['status']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <!-- <a href="<?= route_to('user_index', $level); ?>" class="btn btn-secondary">Kembali</a> -->
                <a href="javascript:window.history.go(-1)" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>