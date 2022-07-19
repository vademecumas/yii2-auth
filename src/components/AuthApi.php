<?php

namespace vademecumas\auth\components;


use vademecumas\auth\helpers\Curl;
use vademecumas\auth\models\AuthApiInterface;
use yii\base\Component;

class AuthApi extends Component implements AuthApiInterface
{
    public $appToken;
    public $appIds;
    public $packageList;
    public $apiUrl;
    public $headers;
    public $errors;
    public $authToken;

    const AUTH_HEADER = "VDMC-USER-AUTH-TOKEN";
    const TOKEN_HEADER = "VDMC-APP-TOKEN";
    const CH_MODE_LOGIN_ONLY = 1;
    const CH_MODE_ALLOW_ALL = 2;
    const CH_MODE_GUEST_ONLY = 3;

    public function init()
    {
        parent::init();
        $this->authToken = \Yii::$app->request->cookies->getValue('authToken');
    }


    public function login($email, $password)
    {
        return $this->send("/user/login", "post", [
            "email" => $email,
            "password" => $password,
            "rememberme" => 1
        ]);
    }


    public function signup($userData)
    {
        return $this->send("/user/create", "post", $userData);
    }

    public function updateProfile($userData)
    {
        return $this->send("/user/update", "post", $userData);
    }

    public function getProfile()
    {
        return $this->send("/user/get");
    }

    public function confirmEmail($token)
    {
        return $this->send("/user/confirm-email?token=" . $token);
    }

    public function createConfirmationToken($email)
    {
        return $this->send("/user/create-confirmation-token?email=" . $email);
    }


    public function accountStatus()
    {
        return $this->send("/user/account-status");
    }

    public function activateUser($key)
    {
        return $this->send("/user/activate", "post", [
            "activation_code" => $key
        ]);
    }

    public function createOrder($packageId, $amount, $appIds, $guestFirstName = null, $guestLastName = null, $guestEmail = null, $guestPhone = null, $checkoutMode = self::CH_MODE_LOGIN_ONLY, $profileHash = null)
    {
        return $this->send("/order/create", "post", [
            "package" => $packageId,
            "amount" => $amount,
            "appIds" => $appIds,
            "guestFirstName" => $guestFirstName,
            "guestLastName" => $guestLastName,
            "guestEmail" => $guestEmail,
            "guestPhone" => $guestPhone,
            "checkoutMode" => $checkoutMode,
            "profileHash" => $profileHash,

        ]);
    }

    public function getOrder($orderHash)
    {
        return $this->send("/order/get?identifier_hash=" . $orderHash);
    }

    public function generateMassKey($packageId, $amount)
    {
        return $this->send("/package/mass-generate", "post", [
            "packageId" => $packageId,
            "amount" => $amount
        ]);
    }


    public function updatePassword($userData)
    {
        return $this->send("/user/update-password", "post", $userData);
    }

    public function requestPasswordReset($userData)
    {
        return $this->send("/user/request-password-reset", "post", $userData);
    }

    public function resetPassword($userData)
    {
        return $this->send("/user/reset-password", "post", $userData);
    }


    public function getFormDropdowns()
    {
        return $this->send("/form/dropdowns");
    }

    protected function send($path, $method = "get", $params = null)
    {
        return Curl::send($this->apiUrl . $path, $method, $params, $this->getHeaders(), $this->errors);
    }

    public function getHeaders()
    {
        $headers[] = self::TOKEN_HEADER . ': ' . $this->appToken;
        if ($this->authToken) {
            $headers[] = self::AUTH_HEADER . ": " . $this->authToken;
        }
        return $headers;
    }

    public function setUserAttributes($model, $userData)
    {
        if ($userData) {
            $model->email = $userData->user->email;
            $model = $this->setUserDataAttributes($model, $userData);
        }

        return $model;
    }

    public function setUserDataAttributes($model, $userData)
    {
        if ($userData) {
            $model->firstName = $userData->user->userData->firstName;
            $model->lastName = $userData->user->userData->lastName;
            $model->occupation = $userData->user->userData->occupation->id;
            $model->tcNo = !empty($userData->user->userData->tcNo) ? $userData->user->userData->tcNo : null;
            $model->birthday = !empty($userData->user->userData->dateOfBirth) ? $userData->user->userData->dateOfBirth : null;
            $model->address = !empty($userData->user->userData->address) ? $userData->user->userData->address : null;
            $model->city = !empty($userData->user->userData->city) ? $userData->user->userData->city->id : null;
            $model->district = !empty($userData->user->userData->district) ? $userData->user->userData->district->id : null;
            $model->billingAddress = !empty($userData->user->userData->billingAddress) ? $userData->user->userData->billingAddress : null;
            $model->billingCity = !empty($userData->user->userData->billingCity) ? $userData->user->userData->billingCity->id : null;
            $model->billingDistrict = !empty($userData->user->userData->billingDistrict) ? $userData->user->userData->billingDistrict->id : null;
            $model->phone = !empty($userData->user->userData->phone) ? $userData->user->userData->phone : null;
            $model->companyName = !empty($userData->user->userData->companyName) ? $userData->user->userData->companyName : null;
            $model->taxNo = !empty($userData->user->userData->taxNo) ? $userData->user->userData->taxNo : null;
            $model->taxOffice = !empty($userData->user->userData->taxOffice) ? $userData->user->userData->taxOffice : null;
            $model->areaofspecialization = !empty($userData->user->userData->areaOfSpecialization) ? $userData->user->userData->areaOfSpecialization->id : null;

        }

        return $model;
    }


    public function generateUserData($model)
    {
        $userData = [
            "firstName" => $model->firstName,
            "lastName" => $model->lastName,
            "occupationId" => (isset($model->occupation) && !empty($model->occupation)) ? $model->occupation : null,
            "areaOfSpecializationId" => (isset($model->areaofspecialization) && !empty($model->areaofspecialization)) ? $model->areaofspecialization : null,
            "cityId" => (isset($model->city) && !empty($model->city)) ? $model->city : null,
            "districtId" => (isset($model->district) && !empty($model->district)) ? $model->district : null,
            "address" => (isset($model->address) && !empty($model->address)) ? $model->address : null,
            "pharmacyDiscountRate" => (isset($model->pharmacydiscountrate) && !empty($model->pharmacydiscountrate)) ? $model->pharmacydiscountrate : null,
            "tcNo" => (isset($model->tcNo) && !empty($model->tcNo)) ? $model->tcNo : null,
            "dateOfBirth" => (isset($model->birthday) && !empty($model->birthday)) ? $model->birthday : null,
            "billingAddress" => (isset($model->billingAddress) && !empty($model->billingAddress)) ? $model->billingAddress : null,
            "billingCityId" => (isset($model->billingCity) && !empty($model->billingCity)) ? $model->billingCity : null,
            "billingDistrictId" => (isset($model->billingDistrict) && !empty($model->billingDistrict)) ? $model->billingDistrict : null,
            "companyName" => (isset($model->companyName) && !empty($model->companyName)) ? $model->companyName : null,
            "taxNo" => (isset($model->taxNo) && !empty($model->taxNo)) ? $model->taxNo : null,
            "taxOffice" => (isset($model->taxOffice) && !empty($model->taxOffice)) ? $model->taxOffice : null,
            "phone" => (isset($model->phone) && !empty($model->phone)) ? $model->phone : null,
            'identifier' => (isset($model->gln) && !empty($model->gln)) ? $model->gln : null,
            'branch' => (isset($model->warehouse_branch) && !empty($model->warehouse_branch)) ? $model->warehouse_branch : null,
        ];

        return $userData;
    }


}