<div class="row">
    <div class="col-12 mt-3">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td rowspan="3" class="text-center align-middle">No</td>
                        <td rowspan="3" class="text-center align-middle">Nama</td>
                        <td colspan="100" class="text-center">Absensi Ke-</td>
                    </tr>
                    <tr>
                        <td colspan="<?= count($absen_ganjil) ?>" class="text-center">Semester 1</td>
                        <td colspan="<?= count($absen_genap) ?>" class="text-center">Semester 2</td>
                    </tr>
                    <tr>
                        <?php if(count($absen_ganjil) == 0): ?>
                                <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                        <?php else : ?>
                            <?php $key_ganjil = 0 ?>
                            <?php foreach ($absen_ganjil as $key_abs => $tgl_ganjil) : ?>
                                <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_ganjil['tanggal'] ?>"><?= $key_ganjil = $key_abs+1 ?> <br> <small> <?= $tgl_ganjil['tanggal'] ?></small></td>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if(count($absen_genap) == 0): ?>
                                <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="">Belum ada absensi</td>
                        <?php else : ?>
                            <?php $key_genap = 0 ?>
                            <?php foreach ($absen_genap as $key_abs => $tgl_genap) : ?>
                                <td class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" style="cursor: pointer;" title="<?= $tgl_genap['tanggal'] ?>"><?= $key_genap = $key_abs+1 ?> <br> <small> <?= $tgl_genap['tanggal'] ?></small></td>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                        <?php if($count_absen == 0): ?>
                        <?php else : ?>
                                <?php $no = 0 ?>
                                <?php foreach ($absen as $key => $value) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no = $no+1 ?></td>
                                        <th class="text-left"><?= $value['siswa_nama'] ?></th>
                                            <?php if(count($absen_ganjil) == 0): ?>
                                                <td class="text-center"></td>
                                            <?php else: ?>
                                                <?php foreach ($absen_ganjil as $key_abs => $tgl_ganjil) : ?>
                                                    <td class="text-center"><?= getAbsensiByDate($tgl_ganjil, $value['anggota_kelas_id']) ?></td>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                            <?php if(count($absen_genap) == 0): ?>
                                                <td class="text-center"></td>
                                            <?php else: ?>
                                                <?php foreach ($absen_genap as $key_abs => $tgl) : ?>
                                                    <td class="text-center"><?= getAbsensiByDate($tgl, $value['anggota_kelas_id']) ?></td>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-12">
            <?php if (count($absen) > 0) : ?>
                <div id="before_<?= $kelas; ?>" class="before">
                    <div class="card-body px-0">
                        <form id="tanggal_<?= $kelas; ?>" action="<?= route_to('cek_absensi'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group col-md-6 px-0">
                                <div id="kelas_jenjang" style="display: none;"><?= $kelas; ?></div>
                                <label for="tanggal" class="mr-1">Tanggal</label>
                                <input class="form-control" type="date" autocomplete="off" name="tanggal">
                                <button onclick="absen()" class="btn btn-primary mt-2 submit-btn" id="submit_<?= $kelas; ?>">Submit</button>
                            </div>
                        </form>
                        <table class="table table-striped">
                            <thead>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Absensi</th>
                            </thead>
                            <tbody>
                                <td colspan="3" class="text-center"><strong>Pilih tanggal terlebih dahulu</strong></td>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="after_<?= $kelas; ?>" style="display: none;">
                    <div class="card-body px-0">
                        <div class="col-md-6">
                            <h5>Tanggal Absen: </h5>
                            <h5 id='tanggal_absensi_<?= $kelas; ?>'></h5>
                        </div>
                        <?= form_open(route_to('panel_wali_insert_absensi')); ?>
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control col-4" name="semester" id="semester_<?= $kelas; ?>">
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                        <table class="table table-striped">
                            <thead class="text-center">
                                <th>NO</th>
                                <th>Nama Siswa</th>
                                <th>Absensi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($absen as $key => $value) : ?>
                                    <tr>
                                        <?= form_input([
                                            'type' => 'hidden',
                                            'name' => 'id_anggota_kelas[]',
                                            'id' => 'id_anggota_kelas',
                                            'value' => $value['anggota_kelas_id']
                                        ]); ?>
                                        <?= form_input([
                                            'type' => 'hidden',
                                            'name' => 'id_kelas[]',
                                            'id' => 'id_kelas',
                                            'value' => $value['kelas_id']
                                        ]); ?>
                                        <?= form_input([
                                            'type' => 'hidden',
                                            'name' => 'tanggal_input',
                                            'id' => 'tanggal_input',
                                        ]); ?>
                                        <?= form_input([
                                            'type' => 'hidden',
                                            'name' => 'id_absensi[]',
                                            'id' => 'id_absensi',
                                            'value' => ''
                                        ]); ?>
                                        <td><?= $no; ?></td>
                                        <td><?= $value['siswa_nama']; ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" name="absensi[<?= $value['anggota_kelas_id'] ?>]" id="data_absensi_<?= $value['anggota_kelas_id']; ?>">
                                                    <option value="">--pilih absensi--</option>
                                                    <option value="hadir">Hadir</option>
                                                    <option value="sakit">Sakit</option>
                                                    <option value="ijin">Ijin</option>
                                                    <option value="tanpa_keterangan">Tanpa Keterangan</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            <?php else : ?>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Absensi</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="text-center"><strong>Tidak ada anggota kelas</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
    </div>
</div>
<?= $this->section('scripts'); ?>

<script>
    function absen() {
        $('form').submit(function(event) {
            var kelas = $(this).children().find('#kelas_jenjang').html();
            if (kelas != undefined) {
                event.preventDefault();
                var form = $(this)
                var data_form = form.serialize();
                var url = form.attr('action');
                console.log(url)
                $.ajax({
                    type: "post",
                    url: url,
                    data: data_form,
                    cache: false,
                    headers: {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        console.log(json);
                        $.each(json.absensi, function(i, val) {
                            $('#data_absensi_' + val.id_anggota_kelas).val(val.kehadiran)
                            $('#semester_' + kelas).val(val.semester)
                            $('#id_absensi').val(val.id)
                        })
                        $('#tanggal_absensi_' + kelas).html(json.tanggal);
                        $('[name="tanggal_input"]').val(json.tanggal);
                        $('#before_' + kelas).css('display', 'none')
                        $('#after_' + kelas).removeAttr('style');
                    }
                });
            }
        })
    }
</script>

<?= $this->endSection(); ?>