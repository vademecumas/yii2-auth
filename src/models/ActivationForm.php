<?php

namespace vademecumas\auth\models;

use Yii;
use yii\base\Model;


/**
 * Subscription form
 */
class ActivationForm extends Model
{
    public $key;

    public function rules()
    {
        $rules = [
            ['key', 'string'],
            ['key', 'required'],
            ['key', 'safe'],
        ];
        return $rules;
    }


    public function attributeLabels()
    {
        return [
            'key' => \Yii::t('auth', 'Activation Code'),

        ];
    }
}
