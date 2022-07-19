<main id="top" class="text-center vertical-space-lg">
    <div class="container">
        <h1 class="headline"><?= Yii::t('auth', 'Sorry') ?>!</h1>
        <h5 class="headline-support"><?= Yii::t('auth', 'Your order could not be received') ?></h5>
        <h5 class="headline-support"><?= $errorMessage ?></h5>

    </div>
</main>
<p class="text-center"><a href="/auth/landing/subscribe" class="btn btn-link"> ← <?= Yii::t('auth', 'Go Back') ?></a>
</p>

