<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Semester Ganjil</h4>
                </div>

                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="accordion" id="accordionGanjil">
                                <div class="card mb-0">
                                    <div class="card-header" id="headingGanjil">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseGanjil" aria-expanded="true" aria-controls="collapseGanjil">
                                                Lihat Absensi Semester Ganjil
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseGanjil" class="collapse" aria-labelledby="headingGanjil" data-parent="#accordionGanjil">
                                        <div class="card-body">
                                            <div class="col-12 mt-3" id="tabelAbsensiGanjil">
                                                <?= $this->include('includes/table_absensi_ganjil'); ?>
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

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Semester Genap</h4>
                </div>

                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="accordion" id="accordionExample">
                                <div class="card mb-0">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Lihat Absensi Semester Genap
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="col-12 mt-3" id="tabelAbsensiGenap">
                                                <?= $this->include('includes/table_absensi_genap'); ?>
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