<?php if ($level == session()->get('level') or isAdmin()) : ?>
    <div class="row">
        <div class="col-sm-3">
            <h6 class="mb-0">Wali Kelas</h6>
        </div>
        <div class="col-sm-9 text-secondary">
            <?php $wali = checkWali($user['id']) ?>
            <?= $wali == null ? '-' : $wali['jenjang'].' '.$wali['kode'] ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3">
            <h6 class="mb-0">Status Jabatan</h6>
        </div>
        <div class="col-sm-9 text-secondary">
            <?= ucfirst(str_replace('_', ' ', $user['status_guru'])) ?? '-' ?>
        </div>
    </div>
    <hr>
<?php endif; ?>