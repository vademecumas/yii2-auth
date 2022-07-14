<?php

use yii\bootstrap4\ActiveForm;

?>
<div class="card">
    <div class="card-body profile-card-body">
        <p class="login-box-msg"><?= \Yii::t('auth', 'Profile Details') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'profile-form']) ?>

        <?= $form->field($model, 'firstName', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'First Name')]) ?>


        <?= $form->field($model, 'lastName', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Last Name')]) ?>


        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><?= \Yii::t('auth', 'Save') ?></button>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>

