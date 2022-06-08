<?php

use yii\helpers\Html;

?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= \Yii::t('auth', 'Reset your password') ?> </p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'password-reset-form']) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => \Yii::t('auth', 'Password')]) ?>

        <?= $form->field($model, 'password2', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => \Yii::t('auth', 'Password2')]) ?>

        <div class="row">
            <div class="col-8">
                &nbsp;
            </div>
            <div class="col-4">
                <?= Html::submitButton(\Yii::t('auth', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <a href="/auth/account/login" class="text-center"><?= \Yii::t('auth', 'Sign In') ?></a>

    </div>
    <!-- /.login-card-body -->
</div>