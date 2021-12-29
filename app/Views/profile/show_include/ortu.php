<?php if($level == session()->get('level') or isAdmin()): ?>
    <div class="row">
        <div class="col-sm-3">
            <h6 class="mb-0">Anak</h6>
        </div>
        <div class="col-sm-9 text-secondary">
            <?= $nama_siswa ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3">
            <h6 class="mb-0">Pekerjaan</h6>
        </div>
        <div class="col-sm-9 text-secondary">
            <?= $user['pekerjaan'] ?? '-' ?>
        </div>
    </div>
    <hr>
<?php endif; ?>