<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kelas <?= convertRoman($kelas_raw['jenjang']) . '' . $kelas_raw['kode'] . ' Tahun Ajaran ' . $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('akademik') ?>">Akademik</a></li>
                    <li class="breadcrumb-item active"><?= $breadcrumb; ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <?= $this->include('layouts/flash'); ?>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Absensi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mt-3">
                                <?= $this->include('includes/table_absensi'); ?>
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
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

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