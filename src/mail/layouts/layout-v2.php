<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
>
<head>
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="format-detection" content="date=no"/>
    <meta name="format-detection" content="address=no"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="x-apple-disable-message-reformatting"/>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,700,700i" rel="stylesheet"/>
    <!--<![endif]-->
    <title>Email Template</title>
    <!--[if gte mso 9]>
    <style type="text/css" media="all">
        sup {
            font-size: 100% !important;
        }
    </style>
    <![endif]-->


    <style type="text/css" media="screen">
        /* Linked Styles */
        body {
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
            min-width: 100% !important;
            width: 100% !important;
            background: #5e8f5a;
            -webkit-text-size-adjust: none
        }

        a {
            color: #dd4b39;
            text-decoration: none
        }

        p {
            padding: 0 !important;
            margin: 0 !important
        }

        img {
            -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */
        }

        .mcnPreviewText {
            display: none !important;
        }


        /* Mobile styles */
        @media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
            .mobile-shell {
                width: 100% !important;
                min-width: 100% !important;
            }

            .bg {
                background-size: 100% auto !important;
                -webkit-background-size: 100% auto !important;
            }

            .text-nav,
            .text-header,
            .m-center {
                text-align: center !important;
            }

            .center {
                margin: 0 auto !important;
            }

            .container {
                padding: 0px 10px 10px 10px !important
            }

            .td {
                width: 100% !important;
                min-width: 100% !important;
            }

            .mbr img {
                border-radius: 8px !important;
            }

            .brl {
                border-radius: 10px !important;
            }

            .brr {
                border-radius: 10px !important;
            }

            .text-nav {
                line-height: 28px !important;
            }

            .p30 {
                padding: 15px !important;
            }

            .m-br-15 {
                height: 15px !important;
            }

            .p30-15 {
                padding: 30px 15px !important;
            }

            .p40 {
                padding: 20px !important;
            }

            .m-td,
            .m-hide {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
                font-size: 0 !important;
                line-height: 0 !important;
                min-height: 0 !important;
            }

            .m-block {
                display: block !important;
            }

            .fluid-img img {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
            }

            .column,
            .column-dir,
            .column-top,
            .column-empty,
            .column-empty2,
            .column-dir-top {
                float: left !important;
                width: 100% !important;
                display: block !important;
            }

            .column-empty {
                padding-bottom: 10px !important;
            }

            .column-empty2 {
                padding-bottom: 20px !important;
            }

            .content-spacing {
                width: 15px !important;
            }
        }
    </style>
</head>
<body class="body"
      style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#ccc; -webkit-text-size-adjust:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ccc">
    <tr>
        <td align="center" valign="top">
            <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                <tr>
                    <td class="td container"
                        style="width:650px; min-width:650px; color: #000; font-size:20pt; line-height:0pt; margin:0; font-weight:normal; padding:10px 0px 10px 0px;">

                    </td>
                </tr>
                <tr>
                    <td class="td container"
                        style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; margin:0; font-weight:normal; ">

                        <?= $content ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

<?php $this->endPage() ?>
