<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url('plugin/filepond/dist/filepond.css') ?>">
    <link href="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.css') ?>" rel="stylesheet" />
<?= $this->endSection() ?>

<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Nama', 'namaPres') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'nama',
            'id' => 'namaPres',
            'value' => set_value('nama') == false && isset($prestasi) ? $prestasi['nama'] : set_value('nama'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Deskripsi Singkat', 'deskripsiPres') ?>
        <?= form_input([
            'type' => 'text',
            'name' => 'deskripsi',
            'id' => 'deskripsiPres',
            'value' => set_value('deskripsi') == false && isset($prestasi) ? $prestasi['deskripsi'] : set_value('deskripsi'),
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
                set_value('kategori') == false && isset($prestasi) ? $prestasi['kategori'] : set_value('kategori'),
                ['class' => 'form-control', 'id' => 'kategoriPres']
            );
        ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Tingkat', 'tingkatPres') ?>
        <?= form_dropdown(
                'tingkat',
                ['' => 'Pilih Tingkat'] + $tingkat,
                set_value('tingkat') == false && isset($prestasi) ? $prestasi['tingkat'] : set_value('tingkat'),
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
            'value' => set_value('konten') == false && isset($prestasi) ? $prestasi['konten'] : set_value('konten'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Thumbnail', 'thumbPres') ?> <br>
        <?= form_upload([
            'type' => 'file',
            'name' => 'thumbnail',
            'id' => 'thumbPres',
            'data-thumbnail' => isset($prestasi) ? base_url($prestasi['thumbnail']) : ''
        ]) ?>
    </div>
</div>

<?= $this->section('scripts') ?>
    <script src="<?= base_url('plugin/filepond/dist/filepond.js') ?>"></script>
    <script src="<?= base_url('plugin/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/file-encode/filepond-plugin-file-encode.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginImagePreview
            )

            let options
            let imageUrl
            const url = window.location

            if (url.pathname.includes('edit')) {
                imageUrl = document.getElementById('thumbPres').getAttribute('data-thumbnail')
                options = {
                    acceptedFileTypes: ['image/png', 'image/jng', 'image/jpeg'],
                    maxFileSize: '500KB',
                    files: [{
                        source: imageUrl,
                        options:{
                            type: 'remote'
                        }
                    }]
                }
            }else{
                options = {
                    acceptedFileTypes: ['image/png', 'image/jng', 'image/jpeg'],
                    maxFileSize: '500KB'
                }
            }

            FilePond.create(
                document.getElementById('thumbPres'), options
            );

            tinymce.init({
                selector: '#kontenPres',
                height: "450",
                images_upload_url: "<?= route_to('tiny_upload') ?>",
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
