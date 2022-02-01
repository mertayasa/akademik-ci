<!-- Content -->
<div class="row">
    <?= $this->include('includes/filter_siswa_absensi'); ?>
    <?= $this->include('includes/info_siswa'); ?>
    <div class="card col-12 mx-2">
        <div class="card-body">
            <?= $this->include('includes/table_absensi_ortu_siswa'); ?>
        </div>
    </div>
</div>