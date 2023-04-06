<?php

use vademecumas\auth\models\UserForm;
use yii\bootstrap4\ActiveForm;

/* @var $model UserForm */
/* @var $creditCardModel \vademecumas\auth\models\CreditCardForm */
/* @var $packageList array */
?>


<div class="card">
    <div class="card-body register-card-body">
        <p class="login-box-msg"><?= \Yii::t('auth', 'Subscribe') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'credit-card-form']) ?>

        <?= $form->field($model, 'step')->label(false)->hiddenInput(['value' => '2']) ?>
        <?= $form->field($model, 'firstName')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'lastName')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'phone')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'email')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'password')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'userAgreement')->label(false)->hiddenInput() ?>
        <?= $form->field($model, 'healthStaff')->label(false)->hiddenInput() ?>


        <?= $form->field($creditCardModel, 'package', [
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])->widget(\kartik\select2\Select2::class, [
            'data' => \yii\helpers\ArrayHelper::map(
                $packageList,
                'slug',
                'name'
            ),
            'model' => $creditCardModel,
            'attribute' => 'package',
            'options' => ['placeholder' => \Yii::t('auth', 'Package')],
            'pluginOptions' => [
                'allowClear' => false
            ],
        ])->label('');
        ?>

        <?= $form->field($creditCardModel, 'cardNumber', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Card Number')]) ?>


        <?= $form->field($creditCardModel, 'expirationDate', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Expiration Date')]) ?>



        <?= $form->field($creditCardModel, 'cardHolderName', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => \Yii::t('auth', 'Card Holder Name')]) ?>

        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block"><?= \Yii::t('auth', 'Save') ?></button>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>

</div>

