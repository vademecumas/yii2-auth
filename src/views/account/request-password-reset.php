<?php

use yii\helpers\Html;

?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= \Yii::t('auth', 'Enter your e-mail address') ?></p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'request-password-reset-form']) ?>

        <?= $form->field($model, 'email', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Email')]) ?>


        <div class="row">
            <div class="col-8">
                &nbsp;
            </div>
            <div class="col-4">
                <?= Html::submitButton(\Yii::t('auth', 'Send'), ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <a href="/auth/account/login" class="text-center"><?= \Yii::t('auth', 'Sign In') ?></a>
    </div>
    <!-- /.login-card-body -->
</div>