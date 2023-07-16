<?php

use App\Components\helpers\Form;

/** @var $id */
/** @var $captchaQuestion */

?>

<?= Form::begin(['class' => 'contact-form', 'id' => $id, 'onclick' => 'return false']) ?>
<div class="contact-form__form row">
    <div class="col-12 col-lg-6">
        <?= Form::input(Form::INPUT_DEFAULT, 'name', trans('site.param.name'), '', ['class' => 'form-control', '@required' => 1, 'autocomplete' => 'off']) ?>
    </div>
    <div class="col-12 col-lg-6">
        <?= Form::input(Form::INPUT_DEFAULT, 'phone', trans('site.param.phone'), '', ['class' => 'form-control', '@required' => 1, 'autocomplete' => 'off']) ?>
    </div>
    <div class="col-12">
        <?= Form::textarea('message', trans('site.param.message'), '', ['class' => 'form-control', '@required' => 1]) ?>
    </div>
    <div class="col-12">
        <?= Form::input(Form::INPUT_DEFAULT, 'description', "$captchaQuestion", '', ['class' => 'form-control', '@required' => 1, 'autocomplete' => 'off']) ?>
    </div>
    <div>
        <?= Form::button(trans('site.contact-form.send'), ['class' => 'btn btn-primary mt-2 contact-form__send']) ?>
    </div>
    <input type="hidden" name="context">
</div>
<div class="contact-form__success col-12 d-none text-center p-5" data-hide="#<?= $id ?> .contact-form__form">
    <?= trans('site.contact-form.success') ?>
</div>
<?= Form::end() ?>
