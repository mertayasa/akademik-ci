<!-- Content -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="col-12 px-0">
                    <form action="<?= route_to('mapel_filter') ?>">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-3 pb-3 pb-md-0">
                                <?= form_label('Pilih Anak', 'idSiswa') ?>
                                <select name="id_siswa" id="idSiswa" class="form-control">
                                    <?php  
                                        $selected = $id_siswa;
                                    ?>
                                    <?php if(isset($siswa)): ?>
                                        <?php foreach($siswa as $sis): ?>
                                            <option value="<?= $sis['id'] ?>" <?= $selected == $sis['id'] ? 'selected' : '' ?> ><?= $sis['nama'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 pb-3 pb-md-0">
                                <button class="btn btn-primary" type="submit"> Jancuk </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <table>
                    <tr>
                        <td>Kelas</td>
                        <td class="px-2">:</td>
                        <td><?= isset($anggota_kelas) ? convertRoman($anggota_kelas['jenjang']).''.$anggota_kelas['kode'] : '-' ?></td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td>
                        <td class="px-2">:</td>
                        <td><?= $wali_kelas ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Ajaran</td>
                        <td class="px-2">:</td>
                        <td><?= isset($anggota_kelas) ? $anggota_kelas['tahun_mulai'].'/'.$anggota_kelas['tahun_selesai'] : '-' ?> </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?= $this->include('jadwal/card'); ?>
</div>