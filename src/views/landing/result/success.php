<!--Preloader div-->
<div class="preloader"></div>

<!-- Header Starts -->
<main id="top" class="text-center vertical-space-lg">
    <div class="container">
        <h1 class="headline"><?= Yii::t('auth', 'Thanks') ?></h1>
        <h5 class="headline-support"><?= Yii::t('auth', 'Your order has been received, you can check your email box to get activation code') ?></h5>
        <div id="moneyorder">
            <p><?= Yii::t('auth', 'Order Number') ?> : <?= $orderId; ?></p>
        </div>

    </div>
</main>
<!-- //   Header Ends -->
<p class="text-center"><a href="/auth/landing/activate-key" class="btn btn-link">
        ← <?= Yii::t('auth', 'Go Back Activation Page') ?></a></p>
