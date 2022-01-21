<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="col-12 px-0">
                <form action="<?= route_to('nilai_filter') ?>">
                    <div class="row align-items-end">
                        <div class="col-12 col-md-3 pb-3 pb-md-0">
                            <?= form_label('Pilih Anak', 'idSiswa') ?>
                            <select name="id_siswa" id="idSiswa" class="form-control">
                                <?php
                                $selected = $id_siswa;
                                ?>
                                <?php if (isset($siswa)) : ?>
                                    <?php foreach ($siswa as $sis) : ?>
                                        <option value="<?= $sis['id'] ?>" <?= $selected == $sis['id'] ? 'selected' : '' ?>><?= $sis['nama'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 pb-3 pb-md-0">
                            <button class="btn btn-primary" type="submit"> Pilih Siswa </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>