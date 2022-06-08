<?php

use yii\helpers\Html;

?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?= \Yii::t('auth', 'Sign in to start your session') ?></p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'email', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Email')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => \Yii::t('auth', 'Password')]) ?>

        <div class="row">
            <div class="col-8">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="icheck-primary">{input}{label}</div>',
                    'labelOptions' => [
                        'class' => ''
                    ],
                    'uncheck' => null,
                ])->label(\Yii::t('auth', 'Remember Me')) ?>
            </div>
            <div class="col-4">
                <?= Html::submitButton(\Yii::t('auth', 'Sign In'), ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <p class="mb-1">
            <a href="/auth/account/request-password-reset"><?= \Yii::t('auth', 'I forgot my password') ?></a>
        </p>

        <?php if ($enableRegister): ?>
            <p class="mb-0">
                <a href="/auth/account/register"
                   class="text-center"><?= \Yii::t('auth', 'Register a new membership') ?></a>
            </p>
        <?php endif; ?>
    </div>
    <!-- /.login-card-body -->
</div>