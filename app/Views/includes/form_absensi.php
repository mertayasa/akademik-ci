<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Manajemen Absensi</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (count($absen) > 0) : ?>
                            <div id="before_<?= $kelas; ?>" class="before">
                                <div class="card-body px-0 py-0">
                                    <form id="tanggal_<?= $kelas; ?>" action="<?= route_to('cek_absensi'); ?>" method="post">
                                        <?= csrf_field(); ?>
                                        <div class="form-group col-12 col-md-4 px-0">
                                            <div id="kelas_jenjang" style="display: none;"><?= $kelas; ?></div>
                                            <label for="tanggal" class="mr-1">Tanggal</label>
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="date" autocomplete="off" name="tanggal">
                                                <div class="input-group-prepend">
                                                    <button onclick="absen()" class="btn btn-primary submit-btn" id="submit_<?= $kelas; ?>">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="initTable">
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
                                <div class="card-body px-0 pt-0">
                                    <?= form_open(route_to('insert_absensi'), ['id' => 'formUpdateAbsensi']); ?>
                                    <?= csrf_field(); ?>
                                    <?= form_input([
                                        'type' => 'hidden',
                                        'name' => 'id_tahun_ajar',
                                        'id' => 'id_tahun_ajar',
                                        'value' => $tahun_ajar['id']
                                    ]); ?>
                                    <?= form_input([
                                        'type' => 'hidden',
                                        'name' => 'id_kelas',
                                        'id' => 'id_kelas',
                                        'value' => $kelas_raw['id']
                                    ]); ?>
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
                                                            <select class="form-control select-absensi" name="absensi[<?= $value['anggota_kelas_id'] ?>]" id="data_absensi_<?= $value['anggota_kelas_id']; ?>">
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
                                    <button type="button" id="btnUpdateAbsensi" onclick="updateAbsensi()" class="btn btn-primary">Submit</button>
                                    <button type="button" id="btnDeleteAbsensi" onclick="deleteAbsensi()" class="btn btn-danger d-none">Hapus Absensi</button>
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

<?= $this->section('scripts'); ?>
    <script>
        function absen() {
            $('form').submit(function(event) {
                let kelas = $(this).children().find('#kelas_jenjang').html();
                if (kelas != undefined) {
                    event.preventDefault();
                    let form = $(this)
                    let data_form = form.serialize();
                    let url = form.attr('action');
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
                            let json = JSON.parse(data)
                            console.log(json);
                            if(json.absensi.length < 1){
                                refreshForm()
                                toogleDeleteButton('hide')
                            }else{
                                $.each(json.absensi, function(i, val) {
                                    $('#data_absensi_' + val.id_anggota_kelas).val(val.kehadiran)
                                    $('#semester_' + kelas).val(val.semester)
                                    $('#id_absensi').val(val.id)
                                })
                                const btnDeleteAbsensi = document.getElementById('btnDeleteAbsensi')
                                btnDeleteAbsensi.setAttribute('data-tanggal', json.tanggal)
                                btnDeleteAbsensi.setAttribute('data-id-kelas', json.absensi[0]['id_kelas'])
                                toogleDeleteButton('show')
                            }

                            $('[name="tanggal_input"]').val(json.tanggal);
                            $('#initTable').css('display', 'none')
                            $('#after_' + kelas).removeAttr('style');
                        }
                    });
                }
            })
        }
        
        function deleteAbsensi(){
            const btnDeleteAbsensi = document.getElementById('btnDeleteAbsensi')
            const deleteUrl = `${baseUrl}/absensi/destroy/${btnDeleteAbsensi.getAttribute('data-tanggal')}/${btnDeleteAbsensi.getAttribute('data-id-kelas')}`
            console.log(deleteUrl)
            Swal.fire({
                title: "Warning",
                text: `Yakin menghapus data absensi tanggal ${btnDeleteAbsensi.getAttribute('data-tanggal')} Proses ini tidak dapat diulang`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#169b6b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        },
                        method: 'GET',
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.code == 1) {
                            refreshTable(data)
                            refreshForm()
                            toogleDeleteButton('hide')
                        }

                        console.log(data);
                        return showAlertSwal(data.code, data.message)
                    })
                    .catch((error) => {
                        showAlertSwal(0, 'Gagal menghapus absensi')
                    })

                }
            })
        }

        function refreshTable(data){
            const tabelAbsensiGanjil = document.getElementById('tabelAbsensiGanjil')
            const tabelAbsensiGenap = document.getElementById('tabelAbsensiGenap')
            
            tabelAbsensiGanjil.innerHTML = ''
            tabelAbsensiGenap.innerHTML = ''
            
            tabelAbsensiGanjil.insertAdjacentHTML('beforeend', data.view_absensi_ganjil)
            tabelAbsensiGenap.insertAdjacentHTML('beforeend', data.view_absensi_genap)
        }

        function refreshForm(data){
            const selectAbsensi = document.getElementsByClassName('select-absensi')
            for (let index = 0; index < selectAbsensi.length; index++) {
                const element = selectAbsensi[index]
                element.value = ''
            }
        }

        function toogleDeleteButton(action){
            if(action == 'show'){
                btnDeleteAbsensi.classList.remove('d-none')
            }else{
                btnDeleteAbsensi.classList.add('d-none')
            }
        }

        function updateAbsensi(){
            const formUpdateAbsensi = document.getElementById('formUpdateAbsensi')
            const formData = new FormData(formUpdateAbsensi)
            const actionUrl = formUpdateAbsensi.getAttribute('action')

            fetch(actionUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                },
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.code == 1) {
                    refreshTable(data)
                    toogleDeleteButton('show')
                }

                return showAlertSwal(data.code, data.message)
            })
            .catch((error) => {
                showAlertSwal(0, 'Gagal melakukan absensi')
            })
        }
    </script>
<?= $this->endSection(); ?>