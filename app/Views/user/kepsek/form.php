<?= $this->section('styles'); ?>
    <link rel="stylesheet" href="<?= base_url('plugin/filepond/dist/filepond.css') ?>">
    <link href="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.css') ?>" rel="stylesheet" />
<?= $this->endSection() ?>

<?= csrf_field() ?>
<?= $this->include('user/form_auth') ?>
<hr>
<div class="row">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <div>
            <?= form_label('Nama', 'namaKepsek') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'nama',
                'id' => 'namaKepsek',
                'value' => set_value('nama') == false && isset($kepsek) ? $kepsek['nama'] : set_value('nama'),
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="mt-3">
            <?= form_label('No Telpon', 'noTelp') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'no_telp',
                'id' => 'noTelp',
                'value' => set_value('no_telp') == false && isset($kepsek) ? $kepsek['no_telp'] : set_value('no_telp'),
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="mt-3">
            <?= form_label('NIP', 'nipKepsek') ?>
            <?= form_input([
                'type' => 'text',
                'name' => 'nip',
                'id' => 'nipKepsek',
                'value' => set_value('nip') == false && isset($kepsek) ? $kepsek['nip'] : set_value('nip'),
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="mt-3">
            <?= form_label('Foto Profil', 'fotoKepsek') ?> <br>
            <?= form_upload([
                'type' => 'file',
                'name' => 'foto',
                'id' => 'fotoKepsek',
                'data-foto' => isset($kepsek) ? base_url($kepsek['foto']) : ''
            ]) ?>
        </div>

    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <div>
            <?= form_label('Bio', 'bioKepsek') ?>
            <?= form_textarea([
                'type' => 'text',
                'name' => 'bio',
                'id' => 'bioKepsek',
                'value' => set_value('bio') == false && isset($kepsek) ? $kepsek['bio'] : set_value('bio'),
                'class' => 'form-control',
                'style' => 'height: 540px'
            ]) ?>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
    <script src="<?= base_url('plugin/filepond/dist/filepond.js') ?>"></script>
    <script src="<?= base_url('plugin/tinymce/js/tinymce/tinymce.min.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/file-encode/filepond-plugin-file-encode.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/validate-type/filepond-plugin-file-validate-type.js') ?>"></script>
    <script src="<?= base_url('plugin/filepond/dist/image-preview/filepond-plugin-image-preview.js') ?>"></script>
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
                imageUrl = document.getElementById('fotoKepsek').getAttribute('data-foto')
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
                document.getElementById('fotoKepsek'), options
            );
        })
    </script>
<?= $this->endSection() ?>
