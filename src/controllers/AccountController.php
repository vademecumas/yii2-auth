<?php

namespace vademecumas\auth\controllers;

use frontend\models\search\UserInboxSearch;
use vademecumas\auth\Auth;
use vademecumas\auth\behaviors\LanguageSwitchBehavior;
use vademecumas\auth\models\AgreementApiInterface;
use vademecumas\auth\models\AuthApiInterface;
use vademecumas\auth\models\CreditCardForm;
use vademecumas\auth\models\User;
use vademecumas\auth\models\UserForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `auth` module
 */
class AccountController extends Controller
{

    /**
     * @var AuthApiInterface
     */
    protected $authComponent;

    /**
     * @var AgreementApiInterface
     */
    protected $agreementComponent;

    /**
     * @var Auth
     */
    protected $authModule;

    /**
     * @var string
     */
    protected $appDir;


    public function init()
    {
        parent::init();

        $this->layout = 'main';
        $this->authModule = Yii::$app->getModule('auth');
        $this->authComponent = $this->authModule->authApi;
        if ($this->authModule->enableAgreement) {
            $this->agreementComponent = $this->authModule->agreementApi;
        }
        $this->appDir = Yii::getAlias('@app');


        Yii::$app->setLayoutPath("/");
        $this->setViewPath($this->appDir . "/views/auth/account");
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
     * Renders the login view for the module
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserForm();
        $model->password = '';
        $model->setScenario(UserForm::SCENARIO_LOGIN);

        if (Yii::$app->request->isPost) {

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                $loginResponse = $this->authComponent->login($model->email, $model->password);

                if ($loginResponse) {

                    $user = User::findOne(['auth_api_id' => $loginResponse->user->id]);

                    if ($user = $this->saveUser($loginResponse, $user, false)) {

                        $this->authComponent->authToken = $user->auth_key;
                        $userInfo = $this->authComponent->getProfile();

                        if ($userInfo) {

                            $session = Yii::$app->session;
                            $session->set('demo', false);

                            $expireDuration = 0;
                            $expireDateTime = 0;
                            if ($model->rememberMe) {
                                $expireDuration = 60 * 60 * 24 * 365;
                                $expireDateTime = time() + $expireDuration;
                            }

                            Yii::$app->user->login($user, $expireDuration);

                            $cookies = Yii::$app->response->cookies;
                            $cookies->add(new \yii\web\Cookie([
                                'name' => 'authToken',
                                'value' => $loginResponse->user->authToken,
                                'expire' => $expireDateTime,
                            ]));

                            Yii::$app->session->set("userData", $userInfo);

                            return $this->goBack();
                        }
                    }
                } else {
                    \Yii::$app->getSession()->setFlash('error', \Yii::t('auth', 'Invalid or wrong email address or password!'));
                }
            }
        }

        return $this->render('login', [
            'model' => $model,
            'enableRegister' => $this->authModule->enableRegister
        ]);
    }

    /**
     * Signs user up.
     * @return mixed
     */
    public function actionRegister($package = '')
    {
        $agreement = null;
        if ($this->authModule->enableAgreement) {
            $agreement = $this->agreementComponent->activeAgreement();
        }

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserForm();
        $model->setScenario(UserForm::SCENARIO_SIGNUP_WITHOUT_PHONE);
        $model->userAgreement = 1;
        $model->healthStaff = 1;

        $creditCardModel = new CreditCardForm();
        $creditCardModel->package = $package;

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($this->authModule->registrationType == Auth::REGISTRATION_TYPE_WITH_SUBSCRIPTION && $model->step == UserForm::STEP_REGISTER) {

                return $this->render('subscribe', [
                    'model' => $model,
                    'creditCardModel' => $creditCardModel,
                    'formDropdowns' => $this->authComponent->getFormDropdowns(),
                    'package' => $package,
                    'packageList' => $this->authComponent->packageList

                ]);
            }

            $creditCardData = [];
            if ($this->authModule->registrationType == Auth::REGISTRATION_TYPE_WITH_SUBSCRIPTION && $model->step == UserForm::STEP_SUBSCRIBE) {
                if ($creditCardModel->load(Yii::$app->request->post()) && $creditCardModel->validate()) {
                    $creditCardData = [
                        "cardNumber" => str_replace(" ", "", $creditCardModel->cardNumber),
                        "expirationDate" => $creditCardModel->expirationDate,
                        "cardHolderName" => $creditCardModel->cardHolderName
                    ];
                } else {
                    return $this->render('subscribe', [
                        'model' => $model,
                        'creditCardModel' => $creditCardModel,
                        'formDropdowns' => $this->authComponent->getFormDropdowns(),
                        'package' => $package,
                        'packageList' => $this->authComponent->packageList

                    ]);
                }
            }


            $createUserData = [
                "firstName" => $model->firstName,
                "lastName" => $model->lastName,
                "occupationId" => (isset($model->occupation) && !empty($model->occupation)) ? $model->occupation : 1,
                "areaOfSpecializationId" => (isset($model->areaofspecialization) && !empty($model->areaofspecialization)) ? $model->areaofspecialization : null,
                "cityId" => (isset($model->city) && !empty($model->city)) ? $model->city : null,
                "districtId" => (isset($model->district) && !empty($model->district)) ? $model->district : null,
                "address" => (isset($model->address) && !empty($model->address)) ? $model->address : null,
                "tcNo" => (isset($model->tcNo) && !empty($model->tcNo)) ? $model->tcNo : null,
                "billingAddress" => (isset($model->billingAddress) && !empty($model->billingAddress)) ? $model->billingAddress : null,
                "billingCityId" => (isset($model->billingCity) && !empty($model->billingCity)) ? $model->billingCity : null,
                "billingDistrictId" => (isset($model->billingDistrict) && !empty($model->billingDistrict)) ? $model->billingDistrict : null,
                "companyName" => (isset($model->companyName) && !empty($model->companyName)) ? $model->companyName : null,
                "taxNo" => (isset($model->taxNo) && !empty($model->taxNo)) ? $model->taxNo : null,
                "taxOffice" => (isset($model->taxOffice) && !empty($model->taxOffice)) ? $model->taxOffice : null,
                "phone" => (isset($model->phone) && !empty($model->phone)) ? str_replace(' ', '', $model->phone) : null,
                'identifier' => (isset($model->gln) && !empty($model->gln)) ? $model->gln : null,
                'branch' => (isset($model->warehouse_branch) && !empty($model->warehouse_branch)) ? $model->warehouse_branch : null,
            ];

            $userData = [
                "email" => $model->email,
                "password" => $model->password,
                "userData" => $createUserData,
                "creditCardData" => $creditCardData,
                "appIds" => $this->authComponent->appIds,
                "shouldVerifyEmail" => $this->authModule->shouldVerifyEmail ? 1 : 0
            ];

            // Signup
            $createResponse = $this->authComponent->signup($userData);

            if (!empty($this->authComponent->errors)) {
                if (!empty($this->authComponent->errors->form_errors)) {
                    if (!empty($this->authComponent->errors->form_errors->email)) {
                        \Yii::$app->getSession()->setFlash('error', \Yii::t('auth', 'The e-mail address has already been registered.'));
                    }
                    if (!empty($this->authComponent->errors->form_errors->phone)) {
                        \Yii::$app->getSession()->setFlash('error', \Yii::t('auth', 'Invalid Phone Number'));
                    }

                    if (!empty($this->authComponent->errors->form_errors->_general_errors)) {
                        $errorMessage = $this->authComponent->errors->form_errors->_general_errors[0];
                        \Yii::$app->getSession()->setFlash('error', \Yii::t('auth', $errorMessage));
                        if ($errorMessage == 'Please check your card information') {
                            return $this->render('subscribe', [
                                'model' => $model,
                                'creditCardModel' => $creditCardModel,
                                'formDropdowns' => $this->authComponent->getFormDropdowns(),
                                'package' => $package,
                                'packageList' => $this->authComponent->packageList

                            ]);
                        }
                    }

                    return $this->render('register', [
                        'model' => $model,
                        'formDropdowns' => $this->authComponent->getFormDropdowns()
                    ]);
                }
            }

            if (!$createResponse) {
                return $this->redirect("/auth/account/register");
            }

            $loginResponse = $this->authComponent->login($model->email, $model->password);

            if (!$loginResponse) {
                return $this->redirect("/auth/account/register");
            }

            if ($user = $this->saveUser($loginResponse, null, true)) {

                $this->authComponent->authToken = $user->auth_key;
                $userInfo = $this->authComponent->getProfile();

                if ($userInfo) {

                    //agreement component
                    if ($this->authModule->enableAgreement) {
                        //get active agreement
                        $aggrement = $this->agreementComponent->activeAgreement();

                        //approve agreement
                        $ip = Yii::$app->request->getUserIP();
                        $this->agreementComponent->approve($aggrement['id'], $user->auth_api_id, $ip, 1);
                    }

                    //send verification email
                    if ($this->authModule->shouldVerifyEmail) {
                        $this->sendVerificationEmail($model->email, $createResponse->user->emailConfirmationToken);
                    }

                    //login registered user
                    Yii::$app->user->login($user, 3600 * 24 * 360);
                    Yii::$app->session->set("userData", $userInfo);
                    $cookies = Yii::$app->response->cookies;
                    $cookies->add(new \yii\web\Cookie([
                        'name' => 'authToken',
                        'value' => $loginResponse->user->authToken,
                        'expire' => time() + 86400 * 365,
                    ]));
                    return $this->goHome();

                }
            }
        }

        return $this->render('register', [
            'model' => $model,
            'agreement' => $agreement,
            'formDropdowns' => $this->authComponent->getFormDropdowns()
        ]);

    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionUpdatePassword()
    {
        $this->layout = $this->appDir . "/views/authenticated/layouts/main";

        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_CHANGE_PASSWORD;

        $userInfo = $this->authComponent->getProfile();

        $model = $this->authComponent->setUserAttributes($model, $userInfo);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                $userData = [
                    "currentPassword" => $model->currentPassword,
                    "password" => $model->password,
                    "password2" => $model->password2,
                ];
                $response = $this->authComponent->updatePassword($userData);
                if ($response) {
                    Yii::$app->session->setFlash("success", \Yii::t('auth', 'Your password has been changed successfully.'));
                }
            } else {
                $errors = [];
                foreach ($model->errors as $error) {
                    $errors[] = $error[0];
                }
                \Yii::$app->getSession()->setFlash('error', implode(" ", $errors));
            }
        }

        return $this->render('profile', [
            'model' => $model,
            'tab' => 'password'
        ]);
    }

    /**
     * Password reset action.
     * @return Response
     */
    public function actionRequestPasswordReset()
    {

        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_REQUEST_RESET_PASSWORD;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $userData = [
                    "email" => $model->email,
                ];

                $response = $this->authComponent->requestPasswordReset($userData);
                if ($response && (isset($response->hash) && !empty($response->hash))) {
                    $mailParams = array(
                        'hash' => $response->hash,
                    );

                    Yii::$app->mailer->htmlLayout = "@app/mail/layouts/layout-v2";
                    Yii::$app->mailer->compose([
                        'html' => '@app/mail/passwordResetToken-html',
                        'text' => '@app/mail/passwordResetToken-text'
                    ], $mailParams)
                        ->setTo($model->email)
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                        ->setSubject(Yii::$app->name . ' - ' . \Yii::t('auth', 'Password Reminder'))
                        ->send();

                    Yii::$app->session->setFlash("success", \Yii::t('auth', 'Your password has been sent to your registered e-mail address.'));

                } else {
                    Yii::$app->session->setFlash("error", \Yii::t('auth', 'No registered e-mail address found'));
                }

                return $this->redirect("/auth/account/request-password-reset");
            }
        }

        return $this->render('request-password-reset', [
            'model' => $model,
        ]);
    }

    /**
     * Password reset action.
     * @return Response
     */
    public function actionPasswordReset($hash = null)
    {
        if ($hash === null) {
            return $this->redirect("/auth/account/request-password-reset");
        }

        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_RESET_PASSWORD;

        $userData = [
            "hash" => $hash,
        ];

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $userData["password"] = $model->password;
                $userData["password2"] = $model->password2;
                $response = $this->authComponent->resetPassword($userData);

                if ($response) {
                    Yii::$app->session->setFlash("success", \Yii::t('auth', 'Your password has been updated. You can login with your new password'));
                    return $this->redirect("/auth/account/login");
                } else {
                    Yii::$app->session->setFlash("error", \Yii::t('auth', 'Since your password has been reset via this link before, please ask for the password reminder e-mail on the login screen.'));
                }
            } else {
                Yii::error(json_encode($model->getErrors()), "validation error");
            }
        }

        return $this->render('password-reset', [
            'model' => $model,
        ]);
    }


    /**
     * Verify email action.
     * @return Response
     */
    public function actionVerifyEmail($token = null)
    {
        if ($token === null) {
            return $this->redirect("/auth/account/resend-verification-email");
        }

        //verify user on auth module
        $response = $this->authComponent->confirmEmail($token);
        if (!$response) {
            Yii::$app->session->setFlash("error", \Yii::t('auth', 'We encountered an error while verifying your e-mail address. Try sending an e-mail verification e-mail again.'));
            return $this->redirect("/auth/account/resend-verification-email");
        }

        //verify user on project
        $this->verifyUser($response->user->id);

        //send welcome mail
        Yii::$app->mailer->htmlLayout = "@app/mail/layouts/layout-v2";
        Yii::$app->mailer->compose([
            'html' => '@app/mail/welcome-html',
            'text' => '@app/mail/welcome-text'
        ], [])
            ->setTo($response->user->email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::$app->name . ' - ' . \Yii::t('auth', 'Welcome'))
            ->send();


        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
        Yii::$app->session->removeAll();

        Yii::$app->session->setFlash("success", \Yii::t('auth', 'Your email address has been verified'));
        return $this->redirect("/auth/account/login");

    }


    /**
     * Resend verification email action.
     * @return Response
     */
    public function actionResendVerificationEmail()
    {

        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_RESEND_VERIFICATION_EMAIL;

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                $response = $this->authComponent->createConfirmationToken($model->email);
                if ($response) {
                    $this->sendVerificationEmail($model->email, $response->user->emailConfirmationToken);
                    Yii::$app->session->setFlash("success", \Yii::t('auth', 'The verification mail has been successfully sent to your registered address in the system.'));

                } else {
                    Yii::$app->session->setFlash("error", \Yii::t('auth', 'No registered e-mail address found'));

                }

            }
        }

        return $this->render('resend-verification-email', [
            'model' => $model,
        ]);
    }

    /**
     * Profile page
     * @return mixed
     */
    public function actionProfile()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect("/auth/account/login");
        }

        $this->layout = $this->appDir . "/views/authenticated/layouts/main";

        $model = new UserForm();
        $model->setScenario(UserForm::SCENARIO_ACCOUNT_INFO);
        $userInfo = $this->authComponent->getProfile();

        $model = $this->authComponent->setUserAttributes($model, $userInfo);


        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

            if ($model->validate()) {

                $userData = [
                    "user" => $this->authComponent->generateUserData($model)
                ];

                if ($this->authComponent->updateProfile($userData)) {
                    Yii::$app->session->setFlash("success", \Yii::t('auth', 'Your profile details has been updated successfully'));
                    return $this->redirect("/auth/account/profile");
                } else {
                    if (!empty($this->authComponent->errors)) {
                        if (!empty($this->authComponent->errors->form_errors)) {
                            $arr = [];
                            foreach ($this->authComponent->errors->form_errors as $formError) {
                                $arr[] = $formError[0];
                            }
                            \Yii::$app->getSession()->setFlash('error', implode(" ", $arr));
                        }
                    }

                }
            } else {
                \Yii::$app->getSession()->setFlash('error', implode(" ", $model->errors));
            }
        }


        return $this->render('profile', [
            'model' => $model,
            'formDropdowns' => $this->authComponent->getFormDropdowns(),
            'tab' => 'profile'
        ]);

    }

    /**
     * Send verification email function.
     * @return Response
     */
    function sendVerificationEmail($email, $token)
    {
        Yii::$app->mailer->htmlLayout = "@app/mail/layouts/layout-v2";
        Yii::$app->mailer->compose([
            'html' => '@app/mail/emailVerify-html',
            'text' => '@app/mail/emailVerify-text'
        ], ['token' => $token])
            ->setTo($email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject(Yii::$app->name . ' - ' . \Yii::t('auth', 'Email Address Verification'))
            ->send();

    }


    /**
     * Agreeemnt action.
     * @return Response
     */
    public function actionAgreement()
    {
        return $this->render('agreement', [
        ]);
    }


    public function verifyUser($id)
    {
        $user = User::findOne(['auth_api_id' => $id]);
        $user->status = User::STATUS_ACTIVE;
        $user->save();
    }

    public function saveUser($response, $user = null, $isRegisterAction)
    {
        if (!$response) {
            return false;
        }

        if (!$user) {

            $status = User::STATUS_ACTIVE;
            if ($isRegisterAction && $this->authModule->shouldVerifyEmail) {
                $status = User::STATUS_ACTIVE;
            }

            $user = new User();
            $user->status = $status;

        }

        $user->auth_api_id = $response->user->id;
        $user->username = $response->user->email;
        $user->email = $response->user->email;
        $user->auth_key = $response->user->authToken;
        $user->password_hash = '';
        if (!$user->save()) {
            Yii::error("couldnt save user", 'commom\models\User saveUser');
            return null;
        }
        return $user;
    }
}
