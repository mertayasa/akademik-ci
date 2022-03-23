<div class="row">
    <div class="container-fluid">
        <?= $this->include('includes/form_absensi'); ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <a href="<?= route_to('detail_absensi', $kelas_raw['id'], $tahun_ajar['id'] ,'ganjil') ?>" class="btn btn-outline-primary btn-block"> <b> Lihat Absensi Semester Ganjil </b> </a>
            </div>
            <div class="col-6">
                <a href="<?= route_to('detail_absensi', $kelas_raw['id'], $tahun_ajar['id'] ,'genap') ?>" class="btn btn-outline-primary btn-block"> <b> Lihat Absensi Semester Genap </b> </a>
            </div>
        </div>
        <hr>
    </div>
</div>

<!-- 
    <div class="col-12 mt-3">
        <div class="col-12" id="tabelAbsensiGanjil">
        <?= ''; //$this->include('includes/table_absensi_ganjil'); ?>
        </div>
        <div class="col-12 mt-3" id="tabelAbsensiGenap">
            <?= ''; //$this->include('includes/table_absensi_genap'); ?>
        </div>
    </div>
 -->