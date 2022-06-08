<?php

namespace vademecumas\auth\components;


use vademecumas\auth\helpers\Curl;
use vademecumas\auth\models\AuthApiInterface;
use yii\base\Component;

class AuthApi extends Component implements AuthApiInterface
{
    public $appToken;
    public $appIds;
    public $apiUrl;
    public $headers;
    public $errors;
    public $authToken;

    const AUTH_HEADER = "VDMC-USER-AUTH-TOKEN";
    const TOKEN_HEADER = "VDMC-APP-TOKEN";

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

    public function update($userData)
    {
        return $this->send("/user/update", "post", $userData);
    }

    public function profile()
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

    public function getDetail($id)
    {
        return $this->send("/interaction-list/get?id=" . $id, "get");
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

}