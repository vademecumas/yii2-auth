<?php

use yii\bootstrap4\ActiveForm;

/* @var $model vademecumas\auth\models\SubscriptionForm */
/* @var $userStatus object */

?>
<div class="card">
    <div class="card-body login-card-body">
        <?php $form = ActiveForm::begin(['id' => 'landing-form']) ?>

        <p class="login-box-msg"><?= \Yii::t('auth', 'Fill the form now,<br/> start using it!') ?></p>

        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($subscriptionForm, 'packageId')->dropDownList(
                    $onlineLandingPackageListDropdown); ?>

            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($subscriptionForm, 'quantity')->dropDownList(
                    array(
                        "1" => "1",
                        "2" => "2",
                        "3" => "3",
                        "4" => "5",
                        "5" => "5",
                        "6" => "6",
                        "7" => "7",
                        "8" => "8",
                        "9" => "9",
                        "10" => "10"
                    )); ?>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 align-right">

                <button type="submit" class="btn btn-primary btn-block"><?= \Yii::t('auth', 'Purchase') ?></button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>

