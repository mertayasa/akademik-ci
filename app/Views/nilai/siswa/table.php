<!-- Content -->
<div class="row">
    <?= $this->include('includes/info_siswa'); ?>
    <?php if (session()->get('level') == 'siswa' or session()->get('level') == 'ortu') : ?>
        <?= $this->include('includes/tabel_nilai_ortu_siswa'); ?>
    <?php else : ?>
        <?= $this->include('includes/tabel_nilai'); ?>
    <?php endif; ?>
</div>