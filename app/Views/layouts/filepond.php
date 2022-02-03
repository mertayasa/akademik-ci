<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url('plugin/filepond/dist/filepond.css') ?>">
<link href="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.css') ?>" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('plugin/filepond/dist/filepond.js') ?>"></script>
<script src="<?= base_url('plugin/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
<script src="<?= base_url('plugin/filepond/dist/file-encode/filepond-plugin-file-encode.js') ?>"></script>
<script src="<?= base_url('plugin/filepond/dist/validate-type/filepond-plugin-file-validate-type.js') ?>"></script>
<script src="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.js') ?>"></script>
<script src="<?= base_url('plugin/filepond/dist/image-crop/filepond-plugin-image-crop.js') ?>"></script>
<script src="<?= base_url('plugin/filepond/dist/image-transform/filepond-plugin-image-transform.js') ?>"></script>
<script src="<?= base_url('plugin/filepond/dist/image-resize/filepond-plugin-image-resize.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        FilePond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
        )

        let options
        let imageUrl
        const url = window.location

        if (url.pathname.includes('edit')) {
            imageUrl = document.getElementById('filePondUpload').getAttribute('data-foto')
            options = {
                acceptedFileTypes: ['image/png', 'image/jng', 'image/jpeg'],
                maxFileSize: '5000KB',
                files: [{
                    source: imageUrl,
                    options: {
                        type: 'remote'
                    }
                }],
            }
        } else {
            options = {
                acceptedFileTypes: ['image/png', 'image/jng', 'image/jpeg'],
                maxFileSize: '5000KB',
            }
        }

        FilePond.create(
            document.getElementById('filePondUpload'), options
        );
    })
</script>
<?= $this->endSection() ?>