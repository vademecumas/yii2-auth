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
                                            Sistemi kullanmak için şu iki adımı takip edin:
                                            <br/>
                                            <ol>
                                                <li>
                                                    <p>
                                                        Varolan hesabınız ile satın almayı tamamladıysanız, <a
                                                                style="color: #D84A38;"
                                                                href="<?= Yii::$app->params['projectUrl'] ?>/auth/account/login">Giriş</a>
                                                        sayfasından, giriş yapabilirsiniz.
                                                    </p>
                                                    <p>
                                                        Yeni hesap açtıysanız <a style="color: #D84A38;"
                                                                                 href="<?= Yii::$app->params['projectUrl'] ?>/auth/account/login">giriş</a>
                                                        yapmak için kayıt sırasında belirlemiş olduğunuz eposta adresi
                                                        ve parolayı kullanabilirsiniz.
                                                    </p>
                                                </li>
                                                <li>Giriş yaptıktan sonra, karşınıza çıkacak olan sayfada bu e-postadaki
                                                    anahtarı kullanarak, hesabınızın aktivasyonunu tamamlayıp,
                                                    kullanmaya başlayabilirsiniz.
                                                </li>
                                            </ol>
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
                                            <strong>Giriş Anahtar(lar)ı</strong><br/>
                                            <? if (isset($keys) && !empty($keys)): ?>
                                                <?php foreach ($keys as $key): ?>
                                                    <span style="color:#F30;">
                                                        <b><?php echo $key; ?></b><br/>
                                                    </span>
                                                <?php endforeach; ?>
                                            <? endif; ?>
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