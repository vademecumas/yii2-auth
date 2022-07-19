<?php

echo "Merhaba" . $name . "\n";
echo "#" . $orderNumber . " numaralı siparişiniz bize ulaştı" . "\n";

echo "Havale işleminiz gerçekleştikten sonra sisteme giriş yapabileceğiniz anahtarlarınız bu e-posta adresinize gönderilecek" . "\n";
echo "Sorularınız için bize " . Yii::$app->params['supportEmail'] . " adresinden veya " . Yii::$app->params['supportPhone'] . " numaralı telefonumuzdan ulaşabilirsiniz" . "\n";
echo Yii::$app->params['supportName'] . "\n\n";

echo "Havale Bilgileri: " . "\n";
echo "Hesap Adı: " . Yii::$app->params['bankAccountInfo']['accountName'];
echo "Banka Hesap Numarası: " . Yii::$app->params['bankAccountInfo']['bankName'] . ", " . Yii::$app->params['bankAccountInfo']['substationName'] . ", Şube Kodu:" . Yii::$app->params['bankAccountInfo']['substationCode'] . ", Hesap No:" . Yii::$app->params['bankAccountInfo']['accountNumber'] . "\n";
echo "IBAN: " . Yii::$app->params['bankAccountInfo']['IBAN'] . "\n";

echo "Fatura Bilgileri: " . "\n";

echo $billingName . "\n";
echo $billingDetails . "\n";
echo $billingAddress . "\n";
