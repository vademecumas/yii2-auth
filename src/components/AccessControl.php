<?php

namespace vademecumas\auth\components;

use Yii;
use yii\base\Module;
use yii\helpers\Url;

class AccessControl extends \yii\base\ActionFilter
{
    public $allowedUrls = [];
    public $forceLogin = false;
    const REGISTER_URL = '/auth/account/register';

    public function beforeAction($action)
    {
        $urlParts = parse_url(Yii::$app->request->url);

        if (Yii::$app->user->isGuest) {

            //redirect guests to login page if required
            if ($this->forceLogin && !in_array($urlParts['path'], $this->allowedUrls)) {
                Yii::$app->user->loginRequired();
                return false;
            }

            //check register page is enabled
            if (!Yii::$app->getModule('auth')->enableRegister && $urlParts['path'] == self::REGISTER_URL) {
                throw new \yii\web\ForbiddenHttpException();
            }

        } else {

            //TODO: fix here
            //check is logged in from another device or is account expired
            $authComponent = Yii::$app->getModule('auth')->authApi;
            $userStatus = $authComponent->accountStatus();
            if (!$userStatus || !$userStatus->accountStatus) {
                Yii::$app->user->logout();
                Yii::$app->user->loginRequired();
                return false;
            }

        }


        return true;

    }


    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }

        $user = Yii::$app->user;
        if ($user->getIsGuest()) {
            $loginUrl = null;
            if (is_array($user->loginUrl) && isset($user->loginUrl[0])) {
                $loginUrl = $user->loginUrl[0];
            } else if (is_string($user->loginUrl)) {
                $loginUrl = $user->loginUrl;
            }
            if (!is_null($loginUrl) && trim($loginUrl, '/') === $uniqueId) {
                return false;
            }
        }

        if ($this->owner instanceof Module) {
            // convert action uniqueId into an ID relative to the module
            $mid = $this->owner->getUniqueId();
            $id = $uniqueId;
            if ($mid !== '' && strpos($id, $mid . '/') === 0) {
                $id = substr($id, strlen($mid) + 1);
            }
        } else {
            $id = $action->id;
        }

        foreach ($this->allowedUrls as $route) {
            if (substr($route, -1) === '*') {
                $route = rtrim($route, "*");
                if ($route === '' || strpos($id, $route) === 0) {
                    return false;
                }
            } else {
                if ($id === $route) {
                    return false;
                }
            }
        }

        if ($action->controller->hasMethod('allowAction') && in_array($action->id, $action->controller->allowAction())) {
            return false;
        }

        return true;
    }
}
