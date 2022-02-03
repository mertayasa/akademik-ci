<?php if ($level == session()->get('level')) : ?>
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

    </div>
    <hr>
<?php endif; ?>