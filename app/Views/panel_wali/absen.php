<div class="row">
    <div class="container-fluid">
        <?= $this->include('includes/form_absensi'); ?>
    </div>
    <div class="col-12 mt-3">
        <div class="col-12" id="tabelAbsensiGanjil">
            <?= $this->include('includes/table_absensi_ganjil'); ?>
        </div>
        <div class="col-12 mt-3" id="tabelAbsensiGenap">
            <?= $this->include('includes/table_absensi_genap'); ?>
        </div>
    </div>
</div>