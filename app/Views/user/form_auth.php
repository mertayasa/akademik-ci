<?php
if (isset($kepsek)) {
    $user = $kepsek;
}
?>

<h6 class="text-primary text-bold">Authentikasi</h6>
<small><sup>*</sup> <i>Mohon untuk mencatat Email dan Password yang akan digunakan pada saat login</i></small><br>

<?php if (isset($level) and $level != 'siswa') : ?>
    <div class="row">
        <div class="col-12 col-md-6 pb-3 pb-md-0">
            <?= form_label('Email', 'emailUser') ?>
            <?= form_input([
                'type' => 'email',
                'name' => 'email',
                'id' => 'emailUser',
                'value' => set_value('email') == false && isset($user) ? $user['email'] : set_value('email'),
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
<?php endif; ?>
<?php if (!isset($level) and !isSiswa()) : ?>
    <div class="row">
        <div class="col-12 col-md-6 pb-3 pb-md-0">
            <?= form_label('Email', 'emailUser') ?>
            <?= form_input([
                'type' => 'email',
                'name' => 'email',
                'id' => 'emailUser',
                'value' => set_value('email') == false && isset($user) ? $user['email'] : set_value('email'),
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
<?php endif; ?>


<div class="row mt-3">
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Password', 'passwordUser') ?>
        <?= form_password([
            'type' => 'password',
            'name' => 'password',
            'id' => 'passwordUser',
            'value' => null,
            'class' => 'form-control'
        ]) ?>
    </div>
    <div class="col-12 col-md-6 pb-3 pb-md-0">
        <?= form_label('Konfirmasi Password', 'passwordConfirmationUser') ?>
        <?= form_input([
            'type' => 'password',
            'name' => 'password_confirmation',
            'id' => 'passwordConfirmationUser',
            'value' => null,
            'class' => 'form-control'
        ]) ?>
    </div>
</div>