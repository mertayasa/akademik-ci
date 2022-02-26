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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Profil Siswa </h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">NIS</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $user['nis'] ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Orang Tua</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $ortu['nama'] ?? '-' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Kelas</h6>
                                            </div>
                                            <?php $kelas = getKelasBySiswa($user['id']); ?>
                                            <div class="col-sm-9 text-secondary">
                                                <?= isset($kelas[0]) ? $kelas[0]['jenjang'] . '' . $kelas[0]['kode'] : 'Tanpa Kelas' ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Tahun Ajar</h6>
                                            </div>
                                            <?php $kelas = getKelasBySiswa($user['id']); ?>
                                            <div class="col-sm-9 text-secondary">
                                                <?= isset($kelas[0]) ? $kelas[0]['tahun_mulai'] . '-' . $kelas[0]['tahun_selesai'] : '-' ?>
                                            </div>
                                        </div>
                                        <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Tanggal Lahir</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <?= \Carbon\Carbon::parse($user['tanggal_lahir'])->format('d/m/Y') ?>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Tempat Lahir</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <?= $user['tempat_lahir'] ?>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Tahun Masuk (Angkatan)</h6>
                                                </div>
                                                <div class="col-sm-9 text-secondary">
                                                    <?= $user['angkatan'] ?>
                                                </div>
                                            </div>
                                            <hr>

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
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Informasi Kepindahan</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Jenis Kepindahan</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                Pindah <?= ucfirst($tipe) ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0"> Tanggal Kepindahan</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= \Carbon\Carbon::parse($pindah_sekolah['tanggal'])->format('d/m/Y') ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Asal Sekolah</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $pindah_sekolah['asal'] ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Tujuan Sekolah</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $pindah_sekolah['tujuan'] ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Tahun Ajar Kepindahan</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $pindah_sekolah['tahun_ajar'] ?>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Alasan Kepindahan</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <?= $pindah_sekolah['alasan'] ?>
                                            </div>
                                        </div>
                                        <hr>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= route_to('pindah_sekolah_index', $tipe); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>