<?php

echo "Merhaba" . $name . "\n";
echo "#" . $orderNumber . " numaralı siparişiniz bize ulaştı" . "\n";

echo "Ürünümüze  göstermiş olduğunuz ilgiden dolayı teşekkür ederiz.\n\n";
echo "Sistemi kullanmak için şu iki adımı takip edin:\n";
echo "1. Varolan hesabınız ile satın almayı tamamladıysanız, " . Yii::$app->params['projectUrl'] . "/auth/account/login sayfasından, giriş yapabilirsiniz veya yeni hesap açtıysanız ayni adresten giriş yapmak için kayıt sırasında belirlemiş olduğunuz eposta adresi ve parolayı kullanabilirsiniz.\n";
echo "2. Giriş yaptıktan sonra, karşınıza çıkacak olan sayfadai bu e-postadaki anahtarı kullanarak, hesabınızın aktivasyonunu tamamlayıp, kullanmaya başlayabilirsiniz.!\n\n";

echo "Sorularınız için bize " . Yii::$app->params['supportEmail'] . " adresinden veya " . Yii::$app->params['projectUrl'] . " numaralı telefonumuzdan ulaşabilirsiniz" . "\n";
echo Yii::$app->params['supportName'] . "\n";

echo "Giriş Anahtarları" . "\n";

if (isset($keys) && !empty($keys)) {
    foreach ($keys as $key) {
        echo $key . "\n";
    }
}

echo "Fatura Bilgileri: " . "\n";

echo $billingName . "\n";
echo $billingDetails . "\n";
echo $billingAddress . "\n";
