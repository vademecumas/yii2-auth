<?php

use yii\bootstrap4\ActiveForm;

/* @var $model vademecumas\auth\models\ActivationForm */
/* @var $userStatus object */

?>
<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'profile-form']) ?>

        <div class="alert alert-danger">
            Aboneliğinizin süresi bitmiş ya da başlatılmamıştır. Lütfen mail adresinize gönderilen abonelik anahtarını
            girin.
        </div>

        <br/>

        <div class="row">
            <div class="col-lg-12">
                <a href="/auth/landing/subscribe"><img src="/images/renew.png"></a>
            </div>
        </div>

        <br/>

        <?php if ($userStatus->package != null): ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label><?= \Yii::t('auth', 'Your Key Group') ?></label>
                        </div>
                        <div class="col-lg-9">
                            : <?= $userStatus->package->name ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($userStatus->key != null): ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label><?= \Yii::t('auth', 'Subscription End Date') ?> </label>
                        </div>
                        <div class="col-lg-9">
                            : <?= \Yii::$app->formatter->asDate($userStatus->key->endsAt) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">


                <?= $form->field($model, 'key', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-key"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                    ->label(false)
                    ->textInput(['placeholder' => 'xxxx-xxxx-xxxx-xxxx']) ?>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 align-right">

                <button type="submit" class="btn btn-primary btn-block"><?= \Yii::t('auth', 'Save') ?></button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>

