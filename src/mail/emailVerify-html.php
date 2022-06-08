<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var $token */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/account/verify-email', 'token' => $token]);
?>
<layout label='CTA'>
    <div class="verify-email">
        <p><?= \Yii::t('auth', 'Hello') ?>,</p>

        <p><?= \Yii::t('auth', 'Follow the link below to verify your email') ?>:</p>

        <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
    </div>
</layout>