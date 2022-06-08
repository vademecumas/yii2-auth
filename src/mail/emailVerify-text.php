<?php

/** @var yii\web\View $this */
/** @var $token */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/account/verify-email', 'token' => $token]);
?>
<?= \Yii::t('auth', 'Hello') ?>,

<?= \Yii::t('auth', 'Follow the link below to verify your email') ?>,:
<?= $verifyLink ?>
