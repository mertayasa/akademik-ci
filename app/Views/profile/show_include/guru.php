<?php if($level == session()->get('level') or isAdmin()): ?>
    <div class="row">
        <div class="col-sm-3">
            <h6 class="mb-0">Status Guru</h6>
        </div>
        <div class="col-sm-9 text-secondary">
            <?= ucfirst($user['status_guru']) ?? '-' ?>
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
<?php endif; ?>