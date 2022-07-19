<?php

namespace vademecumas\auth\models;

use common\models\orm\Orders;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Online Subscription form
 */
class SubscriptionForm extends Model
{
    public $packageId;
    public $quantity;

    public function rules()
    {
        // TODO: Set the messages in language files
        return [
            ['packageId', 'required', 'message' => 'Lütfen abonelik türünü seçin'],
            ['quantity', 'required', 'message' => 'Lütfen abonelik adedini seçin'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'packageId' => Yii::t('auth', 'Subscription Type'),
            'quantity' => Yii::t('auth', 'Number of Subscriptions')
        ];
    }
}
