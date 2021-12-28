<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?php if (!$kepsek && session()->get('level') == 'admin') : ?>
                <div class="card-header">
                    <a href="<?= route_to('kepsek_create') ?>" class="btn btn-primary btn-sm float-right">Tambah Kepala Sekolah</a>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <div class="container">
                    <div class="main-body">

                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="<?= base_url($kepsek['foto']) ?>" style="object-fit:cover" alt="Admin" class="rounded-circle border border-secondary" width="150" height="150">
                                            <div class="mt-3">
                                                <h4><?= $kepsek['nama'] ?></h4>
                                                <p class="text-secondary mb-1">Kepala Sekolah</p>
                                                <p class="text-muted font-size-sm">SDN Nama Sekolah</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">NIP</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $kepsek['nip'] ?? '-' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Email</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $kepsek['email'] ?? '-' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">No Telpon</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $kepsek['no_telp'] ?? '-' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Alamat</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $kepsek['alamat'] ?? '-' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a class="btn btn-info " target="__blank" href="<?= route_to('kepsek_edit', $kepsek['id']) ?>">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row gutters-sm">

                                    <div class="col-12 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3">Bio</h6>
                                                <p>
                                                    <?= $kepsek['bio'] ?? '<i>Bio belum dibuat</i>' ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>