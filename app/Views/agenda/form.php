<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url('plugin/filepond/dist/filepond.css') ?>">
    <link href="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.css') ?>" rel="stylesheet" />
<?= $this->endSection() ?>

    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Judul', 'judul') ?> <br>
        <?= form_input([
            'type' => 'text',
            'name' => 'judul',
            'id' => 'judul',
            'value' => set_value('judul') == false && isset($agenda) ? $agenda['judul'] : set_value('judul'),
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0 mt-3">
        <?= form_label('File', 'fileAgenda') ?> <br>
        <?= form_upload([
            'type' => 'file',
            'name' => 'file',
            'id' => 'fileAgenda',
            'data-file' => isset($agenda) ? base_url($agenda['file']) : ''
        ]) ?>
    </div>

<?= $this->section('scripts') ?>
    <script src="<?= base_url('plugin/filepond/dist/filepond.js') ?>"></script>
    <script src="<?= base_url('plugin/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/file-encode/filepond-plugin-file-encode.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/validate-type/filepond-plugin-file-validate-type.js') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginImagePreview,
                FilePondPluginFileValidateType
            )

            let options
            let imageUrl
            const url = window.location

            if (url.pathname.includes('edit')) {
                imageUrl = document.getElementById('fileAgenda').getAttribute('data-file')
                options = {
                    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg', 'application/pdf'],
                    maxFileSize: '5MB',
                    files: [{
                        source: imageUrl,
                        options:{
                            type: 'remote'
                        }
                    }]
                }
            }else{
                options = {
                    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg', 'application/pdf'],
                    maxFileSize: '5MB',
                }
            }

            FilePond.create(
                document.getElementById('fileAgenda'), options
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
