<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Tahun Ajar <?= $tahun_ajar['tahun_mulai'] . '/' . $tahun_ajar['tahun_selesai'] ?>
                <!-- <a href="<?= route_to('kelas_per_tahun_edit', $tahun_ajar['id']) ?>" class="btn btn-warning btn-sm float-right">Edit Kelas Aktif</a> -->
            </div>
            <div class="card-body">
                <table id="mapelDataTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td class="text-center">Status Aktif</td>
                        </tr>
                    </thead>
                    <?php $no = 1;
                    foreach ($all_kelas as $key => $kelas) : ?>
                        <tbody class="mb-5">
                            <tr>
                                <td colspan="4">  <b> Kelas <?= $key ?> </b></td>
                            </tr>
                            <?php foreach ($kelas as $kel) : ?>
                                <tr>
                                    <td><?= convertRoman($kel['jenjang']) . ' ' . $kel['kode'] ?></td>
                                    <td class="text-center">
                                        <div class="form-group mb-0">
                                            <div class="custom-control custom-switch">
                                                <?= form_open(route_to('kelas_per_tahun_update', $kel['id']), ['id' => 'form'.$kel['id']]); ?>
                                                <?= csrf_field() ?>
                                                    <input type="checkbox" <?= checkKelasByTahun($kel['id'], $tahun_ajar['id']) == true ? 'checked' : '' ?> class="custom-control-input" id="switch<?= $kel['id'] ?>" data-id-kelas="<?= $kel['id'] ?>" onclick="updateStatusKelas(this)">
                                                    <label class="custom-control-label" for="switch<?= $kel['id'] ?>"></label>
                                                <?= form_close() ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    table tbody {
        border-bottom: 15px solid gray;
    }
</style>

<?= $this->section('scripts') ?>
    <script>
        function updateStatusKelas(checkbox){
            const idTahunAjar = "<?= $tahun_ajar['id'] ?>"
            const idKelas = checkbox.getAttribute('data-id-kelas')
            const updateStatusUrl = `${baseUrl}/kelasPerTahun/update/${idKelas}`
            const formData = new FormData(document.getElementById('form' + idKelas))
            formData.append('id_tahun_ajar', idTahunAjar)

            Swal.fire({
                title: "Warning",
                text: `Yakin ingin mengubah status kelas ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#169b6b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(updateStatusUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        },
                        method : 'POST',
                        body : formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.code == 1) {
                            toastr.success(data.message)
                        } else {
                            toastr.error(data.message)
                        }

                    })
                    .catch((error) => {
                        checkbox.checked = !checkbox.checked
                        console.log(error);
                        showAlertSwal(0, 'Gagal mengubah status kelas')
                    })
                }else{
                    checkbox.checked = !checkbox.checked
                }
            })
        }
    </script>
<?= $this->endSection() ?>