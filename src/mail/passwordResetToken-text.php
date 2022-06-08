<?php


/** @var yii\web\View $this */
/** @var $hash */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/account/password-reset', 'token' => $hash]);
?>

<?= \Yii::t('auth', 'Hello') ?>,

<?= \Yii::t('auth', 'Please click to {url} to change your password.', ['url' => $resetLink]) ?>
