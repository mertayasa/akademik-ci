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
        <?= isset($kelas[0]) ? $kelas[0]['jenjang']. '' .$kelas[0]['kode'] : 'Tanpa Kelas' ?> Tahun ajaran <?= isset($kelas[0]) ? $kelas[0]['tahun_mulai']. '-' .$kelas[0]['tahun_selesai'] : '-' ?>
    </div>
</div>
<hr>
<?php if($level == session()->get('level') or isAdmin()): ?>
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
<?php endif; ?>