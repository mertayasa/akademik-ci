<!-- Content -->
<?php foreach ($kelas as $key => $kel) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <table>
                        <tr>
                            <td>Kelas</td>
                            <td class="px-2">:</td>
                            <td><?= convertRoman($kel['jenjang']) . '' . $kel['kode'] ?></td>
                        </tr>
                        <tr>
                            <td>Tahun Ajar</td>
                            <td class="px-2">:</td>
                            <td><?= $kel['tahun_mulai'] . '/' . $kel['tahun_selesai'] ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Siswa</td>
                            <td class="px-2">:</td>
                            <td><?= $kel['jumlah_siswa'] ?></td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab<?= $key ?>" role="tablist">
                            <a class="nav-link active" id="list-siswa-tab<?= $key ?>" data-toggle="tab" href="#list-siswa<?= $key ?>" role="tab" aria-controls="list-siswa<?= $key ?>" aria-selected="true">Siswa</a>
                            <a class="nav-link" id="list-jadwal-tab<?= $key ?>" data-toggle="tab" href="#list-jadwal<?= $key ?>" role="tab" aria-controls="list-jadwal<?= $key ?>" aria-selected="false" data-key="<?= $key; ?>">Jadwal</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent<?= $key ?>">
                        <div class="tab-pane fade show active" id="list-siswa<?= $key ?>" role="tabpanel" aria-labelledby="list-siswa-tab<?= $key ?>"> <?= view_cell('\App\Libraries\Widget::tabSiswa', ['key' => $key, 'tahun_ajar' => $tahun_ajar['id'], 'kelas' => $kel['id_kelas']]) ?> </div>
                        <div class="tab-pane fade" id="list-jadwal<?= $key ?>" role="tabpanel" aria-labelledby="list-jadwal-tab<?= $key ?>"> <?= view_cell('\App\Libraries\Widget::tabJadwal', ['hari' => $kel['hari'], 'jadwal' => $kel['jadwal']]) ?> </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->section('scripts') ?>
<!-- <script>
        $(document).ready(function() {
            $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust().responsive.recalc();
            });
        })
    </script> -->
<script>
    $('#list-jadwal-tab' + <?= $key; ?>).on('click', function() {
        var key = $(this).data('key')
        console.log('asd')
        console.log(key)
        $.ajax({
            type: 'GET',
            url: "<?= route_to('panel_wali_index'); ?>",
            data: {
                'id_kelas': 22
            },
            success: function() {
                console.log('jancok')
            }
        })
    })
</script>
<?= $this->endSection() ?>