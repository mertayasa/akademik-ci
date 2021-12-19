<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url('plugin/filepond/dist/filepond.css') ?>">
<?= $this->endSection() ?>

<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Nama', 'namaPres') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nama',
            'id' => 'namaPres',
            'value' => set_value('nama') == false && isset($mapel) ? $mapel['nama'] : set_value('nama'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Deskripsi Singkat', 'deskripsiPres') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'deskripsi',
            'id' => 'deskripsiPres',
            'value' => set_value('deskripsi') == false && isset($mapel) ? $mapel['deskripsi'] : set_value('deskripsi'),
            'class' => 'form-control'
        ]) ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Kategori', 'kategoriPres') ?>
        <?= form_dropdown(
                'kategori',
                ['' => 'Pilih Kategori'] + $kategori,
                set_value('kategori') == false && isset($mapel) ? $mapel['kategori'] : set_value('kategori'),
                ['class' => 'form-control', 'id' => 'kategoriPres']
            );
        ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tingkat', 'tingkatPres') ?>
        <?= form_dropdown(
                'tingkat',
                ['' => 'Pilih Tingkat'] + $tingkat,
                set_value('tingkat') == false && isset($mapel) ? $mapel['tingkat'] : set_value('tingkat'),
                ['class' => 'form-control', 'id' => 'tingkatPres']
            );
        ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Konten', 'kontenPres') ?>
        <?= form_textarea([
            'type' => 'text',
            'name' => 'konten',
            'id' => 'kontenPres',
            'value' => set_value('konten') == false && isset($mapel) ? $mapel['konten'] : set_value('konten'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Thumbnail', 'thumbPres') ?> <br>
        <?= form_upload([
            'type' => 'file',
            'name' => 'thumbnail',
            'id' => 'thumbPres',
        ]) ?>
    </div>
</div>

<?= $this->section('scripts') ?>
    <script src="<?= base_url('plugin/filepond/dist/filepond.js') ?>"></script>
    <script src="<?= base_url('plugin/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.create(
                document.getElementById('thumbPres'), {
                    acceptedFileTypes: ['image/png', 'image/jng', 'image/jpeg'],
                    maxFileSize: '500KB'
                }
            );

            tinymce.init({
                selector: '#kontenPres',
                height: "450",
                images_upload_url: "route_to('tiny-upload')",
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                plugins: 'preview paste autolink fullscreen image link media table anchor insertdatetime advlist lists wordcount',
                toolbar: 'undo redo | bold italic strikethrough underline numlist bullist removeformat | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | copy paste cut selectall | image | preview',
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px}'
            });
        })
    </script>
<?= $this->endSection() ?>
