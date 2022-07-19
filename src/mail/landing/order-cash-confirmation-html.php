<repeater>
    <!-- CTA -->
    <layout label='CTA'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding-bottom: 10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="p30-15 br" style="padding: 10px 10px; border-radius:10px;"
                                bgcolor="#dd4b39">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="h2 white center pb20"
                                            style="font-family:'Poppins', Arial,sans-serif; font-size:28px; line-height:34px; color:#ffffff; text-align:center; ">
                                            <multiline>
                                                Sipariş Özeti
                                            </multiline>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </layout>
    <!-- END CTA -->

    <!-- CTA -->
    <layout label='CTA'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding-bottom: 10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="p30-15 br" style="padding: 10px 10px 10px 30px; border-radius:10px;"
                                bgcolor="#fff">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="text white center pb30"
                                            style="font-family:'Poppins', Arial,sans-serif; font-size:20px; line-height:30px; color:#3d3d3d; text-align:left; ">
                                            <strong>Merhaba <?php echo $name; ?>,</strong><br/>
                                            Siparişiniz <span style="color:#F30;">#<?php echo $orderNumber; ?></span>
                                            kayıt numarası ile bize ulaşmıştır.
                                            <br/>
                                            Ürünümüze göstermiş olduğunuz ilgiden dolayı teşekkür ederiz.
                                            <br/>
                                            Havale işleminiz gerçekleştikten sonra sisteme giriş yapabileceğiniz
                                            anahtarlarınız
                                            bu e-posta adresinize gönderilecek.
                                        </td>
                                        <td class="text white center pb30"
                                            style="font-family:'Poppins', Arial,sans-serif; font-size:25px; line-height:30px; color:#3d3d3d; text-align:right; ">

                                            <img src="<?php echo Yii::$app->params['projectUrl']; ?>/images/mailing/icon/1.png"
                                                 alt="" style="width: 100px;"/>
                                        </td>
                                    </tr>
                                    <!-- Button -->

                                    <!-- END Button -->
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </layout>
    <!-- END CTA -->

    <!-- CTA -->
    <layout label='CTA'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding-bottom: 10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="p30-15 br" style="padding: 10px 10px 10px 30px; border-radius:10px;"
                                bgcolor="#fff">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="text white center pb30"
                                            style="font-family:'Poppins', Arial,sans-serif; font-size:20px; line-height:30px; color:#3d3d3d; text-align:left; ">
                                            <strong>Havale Bilgileri</strong><br/>
                                            Hesap Adı: <?= Yii::$app->params['bankAccountInfo']['accountName']; ?><br/>
                                            IBAN: <?= Yii::$app->params['bankAccountInfo']['IBAN']; ?><br/>
                                            <?= Yii::$app->params['bankAccountInfo']['bankName']; ?>
                                            , <?= Yii::$app->params['bankAccountInfo']['substationName']; ?>,<br/>
                                            Şube Kodu: <?= Yii::$app->params['bankAccountInfo']['substationCode']; ?>,
                                            Hesap No: <?= Yii::$app->params['bankAccountInfo']['accountNumber']; ?><br/>
                                        </td>
                                        <td class="text white center pb30"
                                            style="font-family:'Poppins', Arial,sans-serif; font-size:15px; line-height:30px; color:#3d3d3d; text-align:right; ">

                                            <img src="<?php echo Yii::$app->params['projectUrl']; ?>/images/mailing/icon/2.png"
                                                 alt="" style="width: 100px;"/>
                                        </td>
                                    </tr>
                                    <!-- Button -->

                                    <!-- END Button -->
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </layout>
    <!-- END CTA -->

    <!-- CTA -->
    <layout label='CTA'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="padding-bottom: 10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="p30-15 br" style="padding: 10px 10px 10px 30px; border-radius:10px;"
                                bgcolor="#fff">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="text white center pb30"
                                            style="font-family:'Poppins', Arial,sans-serif; font-size:15px; line-height:30px; color:#3d3d3d; text-align:left; ">
                                            <strong>Fatura Bilgileri</strong>
                                            <br/>
                                            <?php echo $billingName; ?>
                                            <br/>
                                            <?php echo $billingDetails; ?>
                                            <br/>
                                            <?php echo $billingAddress; ?>
                                            <br/>
                                            <span style="color:#F30;"><?php echo $productDetails; ?></span>
                                        </td>
                                        <td class="text white center pb30"
                                            style="font-family:'Poppins', Arial,sans-serif; font-size:15px; line-height:30px; color:#3d3d3d; text-align:right; ">

                                            <img src="<?php echo Yii::$app->params['projectUrl']; ?>/images/mailing/icon/3.png"
                                                 alt="" style="width: 100px;"/>
                                        </td>
                                    </tr>
                                    <!-- Button -->

                                    <!-- END Button -->
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </layout>
    <!-- END CTA -->

    <!-- END Article Image On The Left / Secondary -->
</repeater>