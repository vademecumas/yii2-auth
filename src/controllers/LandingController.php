<?php

namespace vademecumas\auth\controllers;

use common\models\orm\Orders;
use common\models\orm\OrdersKeys;
use console\jobs\CallRpiJob;
use frontend\models\search\UserInboxSearch;
use vademecumas\auth\behaviors\LanguageSwitchBehavior;
use vademecumas\auth\models\ActivationForm;
use vademecumas\auth\models\Order;
use vademecumas\auth\models\SubscriptionForm;
use Yii;
use yii\web\Controller;

/**
 * Landing controller for the `auth` module
 */
class LandingController extends Controller
{
    protected $authComponent;
    protected $authModule;
    protected $appDir;
    const INDIVIDUAL_PAYMENT = 1;
    const CORPORATE_PAYMENT = 2;
    const CREDIT_CARD_PAYMENT = 1;
    const CASH_PAYMENT = 2;
    const VDMC_ORDER_WT = 6;

    public function init()
    {
        parent::init();

        $this->layout = 'main';
        $this->authModule = Yii::$app->getModule('auth');
        $this->authComponent = $this->authModule->authApi;
        $this->appDir = Yii::getAlias('@app');


        Yii::$app->setLayoutPath("/");
        $this->setViewPath($this->appDir . "/views/auth/landing");
        $this->layout = $this->appDir . "/views/auth/layouts/main";
    }

    public function behaviors()
    {
        return [
            'languageSwitch' => [
                'class' => LanguageSwitchBehavior::class,
            ]
        ];
    }

    /**
     * Profile page
     * @return mixed
     */
    public function actionActivateKey()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect("/auth/account/login");
        }
        $model = new ActivationForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $activation = $this->authComponent->activateUser($model->key);
                if ($activation) {
                    Yii::$app->session->setFlash("success", \Yii::t('auth', 'Activation completed successfully'));
                    return $this->redirect("/");

                } else {
                    Yii::$app->session->setFlash('error', \Yii::t('auth', 'Registration key not found or matched!'));
                }
            }
        }

        $userStatus = $this->authComponent->accountStatus();
        return $this->render('activate-key', [
            'model' => $model,
            'userStatus' => $userStatus,
        ]);

    }

    /**
     * @return string|\yii\web\Response
     * * Landing page
     */
    public function actionSubscribe()
    {
        $packageList = $this->authComponent->packageList;
        $subscriptionForm = new SubscriptionForm();

        $request = Yii::$app->request;
        if ($subscriptionForm->load($request->post()) || $subscriptionForm->load($request->get())) {
            if ($subscriptionForm->validate()) {

                $order = $this->authComponent->createOrder(
                    $subscriptionForm->packageId,
                    $subscriptionForm->quantity,
                    $this->authComponent->appIds
                );

                Yii::debug("ID Order response received: " . print_r($order, true));

                if ($order) {
                    $orderIdentifier = $order->identifierHash;
                    return $this->redirect($this->authComponent->apiUrl . "/payment/payment?order=" . $orderIdentifier);
                } else {
                    Yii::error("An error occurred when creating the order: " . print_r($this->authComponent->errors, true));
                    $subscriptionForm->addError("packageId", "Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz");
                }
            }
        }

        $onlineLandingPackageListDropdown = array();

        foreach ($packageList as $onlineLandingPackage) {
            $onlineLandingPackageListDropdown[$onlineLandingPackage["id"]] = $onlineLandingPackage["name"] . " " . $onlineLandingPackage["price"] . " TL";
        }

        return $this->render(
            "subscribe",
            [
                "subscriptionForm" => $subscriptionForm,
                "onlineLandingPackageListDropdown" => $onlineLandingPackageListDropdown
            ]
        );
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCheckoutResult()
    {
        $orderIdentifier = Yii::$app->request->get("order_identifier_hash");

        $orderInfo = $this->authComponent->getOrder($orderIdentifier);

        if (!$orderInfo) {
            Yii::error("Order details cannot be fetched from Id. Errors: " . print_r($this->authComponent->errors, true) . " Result: " . print_r($orderInfo, true));
            return $this->render(
                "result/error",
                array(
                    "errorMessage" => "Sipariş bilgileri alınamadı. Lütfen daha sonra tekrar deneyiniz."
                )
            );
        }

        $orderId = null;
        // Check if the order is previously used or not...
        if (Order::find()->andWhere(["vdmcid_order_identifier" => $orderInfo->identifierHash])->count() > 0) {
            return $this->render(
                "result/error",
                array(
                    "errorMessage" => "Bu sipariş numarası daha önce kullanılmış. Lütfen destek ekibi ile iletişime geçiniz"
                )
            );
        }

        if (!$orderInfo->isSuccessful) {
            return $this->render(
                "result/error",
                array(
                    "errorMessage" => "Bu siparişin ödemesi alınmamış. Lütfen ödeme işlemini tamamlayıp tekrar deneyiniz"
                )
            );
        }

        $order = $this->createOrder($orderInfo);

        if (!$order) {
            return $this->render(
                "result/error",
                array(
                    "errorMessage" => "Sipariş oluşturulamadı. destek ekibi ile iletişime geçiniz."
                )
            );
        }

        $paymentType = self::CASH_PAYMENT;

        if ($orderInfo->isPaid) {
            Yii::info("Generating keys as the order is already 'paid'");

            $paymentType = self::CREDIT_CARD_PAYMENT;

            $keys = $this->generateKeys($order);
            foreach ($keys as $key) {
                $this->authComponent->activateUser($key);
            }
            if (!$keys) {
                return $this->render(
                    "result/error",
                    array(
                        "errorMessage" => "Anahtar oluşturulamadı. destek ekibi ile iletişime geçiniz"
                    )
                );
            }

            //Send confirmation mail
            $this->sendConfirmationEmail($order, $orderInfo, $keys);
        } else {
            Yii::info("Keys won't be generated as order is waiting for wire transfer");
            $this->sendConfirmationEmail($order, $orderInfo);
        }

        //trigger purchasing webhook
        try {
            Yii::$app->queue->push(new CallRpiJob([
                'type' => 'vdmc-online-purchasing',
            ]));
        } catch (\Exception $exception) {
            Yii::error("An error occurred when  creating rpi job on queue : " . $exception->getMessage());
        }


        // Set flash data for checkout success
        Yii::$app->session->setFlash('orderId', $order->id);
        Yii::$app->session->setFlash('paymentType', $paymentType);

        //For tracking analytics goal
        return $this->redirect("checkout-success");

    }


    /**
     * @return string|\yii\web\Response
     * Checkout success page for tracking analytics goals
     */
    public function actionCheckoutSuccess()
    {
        $orderId = Yii::$app->session->getFlash('orderId');
        $paymentType = Yii::$app->session->getFlash('paymentType');
        if (!$orderId && !$paymentType) {
            return $this->redirect("/auth/landing/subscribe");
        }

        if ($paymentType == self::CASH_PAYMENT) {
            $view = "bank";

        } else {
            $view = "success";
        }

        return $this->render(
            "result/" . $view,
            array(
                "orderId" => $orderId
            )
        );
    }

    /**
     * @param \StdClass $vdmcIdOrder
     * @return Orders|null
     */
    protected function createOrder($vdmcIdOrder)
    {
        $order = new Order();

        if ($vdmcIdOrder->billingInfo->company_name) {
            // Corporate payment
            $order->bill_type = self::CORPORATE_PAYMENT;
        } else {
            // Individual payment
            $order->bill_type = self::INDIVIDUAL_PAYMENT;
        }

        $order->payment_type = $vdmcIdOrder->status === self::VDMC_ORDER_WT ? self::CASH_PAYMENT : self::CREDIT_CARD_PAYMENT;
        $order->amount = $vdmcIdOrder->packageAmount;
        $order->total_amount = $vdmcIdOrder->totalPrice;
        $order->ip_address = Yii::$app->getRequest()->getUserIP();
        $order->package_id = (int)$vdmcIdOrder->packageId;
        $order->vdmcid_order_identifier = $vdmcIdOrder->identifierHash;
        if ($order->save()) {
            return $order;
        }
        Yii::error("Order cannot be saved: " . print_r($order->errors, true));
        return null;
    }

    public function generateKeys(Order $order)
    {
        $keys = [];
        $result = $this->authComponent->generateMassKey($order->package_id, $order->amount);
        if ($result) {

            foreach ($result->keys as $key) {
                array_push($keys, $key->key);
            }

        } else {
            \Yii::error("[" . Yii::$app->params['projectName'] . "] #" . $order->id . " için anahtar yaratılamadı.");
        }

        return $keys;
    }

    protected function sendConfirmationEmail(Order $order, $vdmcIdOrder, $keys = null)
    {
        $html = null;
        $text = null;

        if ($order->bill_type == self::INDIVIDUAL_PAYMENT) {
            $billingName = $vdmcIdOrder->userInfo->name;
            $billingDetails = "T.C. Kimlik Numarası: " . $vdmcIdOrder->billingInfo->tc_no;

        } else if ($order->bill_type == self::CORPORATE_PAYMENT) {
            $billingName = $vdmcIdOrder->billingInfo->company_name;
            $billingDetails = "Vergi Numarası: " . $vdmcIdOrder->billingInfo->company_tax_no . " Vergi Dairesi: " . $vdmcIdOrder->billingInfo->company_tax_office;
        }

        if ($order->payment_type == self::CASH_PAYMENT) {
            $html = "@app/mail/landing/order-cash-confirmation-html.php";
            $text = "@app/mail/landing/order-cash-confirmation-text.php";

        } else if ($order->payment_type == self::CREDIT_CARD_PAYMENT) {
            $html = "@app/mail/landing/order-creditcard-confirmation-html.php";
            $text = "@app/mail/landing/order-creditcard-confirmation-text.php";
        }

        $mailParams = array(
            'name' => $vdmcIdOrder->userInfo->name,
            'orderNumber' => $order->id,
            'billingName' => $billingName,
            'billingDetails' => $billingDetails,
            'billingAddress' => $vdmcIdOrder->billingInfo->city . " " . $vdmcIdOrder->billingInfo->address,
            'keys' => $keys,
            'productDetails' => sprintf("%d adet %s: %s TRY", $vdmcIdOrder->packageAmount, $vdmcIdOrder->packageInfo->name, $vdmcIdOrder->totalPrice),
        );

        Yii::$app->mailer->htmlLayout = "@app/mail/layouts/layout-v2";

        Yii::$app->mailer->compose(
            [
                'html' => $html,
                'text' => $text
            ],
            $mailParams
        )
            ->setFrom(array(Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']))
            ->setTo(array($vdmcIdOrder->userInfo->email))
            ->setBcc(Yii::$app->params['orderInfoRecipients'])
            ->setSubject("[" . Yii::$app->params['projectName'] . "] #" . $order->id . " numaralı sipariş özeti")
            ->send();
    }


}
