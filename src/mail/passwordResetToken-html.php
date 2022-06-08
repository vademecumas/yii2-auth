<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var $hash */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/account/password-reset', 'hash' => $hash]);
?>
<div class="password-reset">
    <p><?= \Yii::t('auth', 'Hello') ?>,</p>

    <p><?= \Yii::t('auth', 'Please click the link below to change your password') ?>:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>

</div>
