<?php

namespace vademecumas\auth\behaviors;

use yii\base\Behavior;
use yii\web\Controller;

class LanguageSwitchBehavior extends Behavior
{
    public $queryParam = 'language';

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'switchLanguage',
        ];
    }

    public function switchLanguage()
    {
        $language = \Yii::$app->request->get($this->queryParam);
        if ($language) {
            \Yii::$app->session->set('language', $language);
        }

        $sessionLanguage = \Yii::$app->session->get('language');
        if ($sessionLanguage) {
            \Yii::$app->language = $sessionLanguage;

        }
    }
}
