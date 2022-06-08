<?php

use yii\helpers\Html;

?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= \Yii::t('auth', 'Please fill out your email. A verification email will be sent there.') ?></p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'resend-verification-email-form']) ?>

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
    </div>
    <!-- /.login-card-body -->
</div>