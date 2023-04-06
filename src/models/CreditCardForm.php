<?php

namespace vademecumas\auth\models;

use common\models\orm\Orders;
use common\models\User;
use Inacho\CreditCard;
use Yii;
use yii\base\Model;

/**
 * Credit Card form
 */
class CreditCardForm extends Model
{
    public $package;
    public $cardNumber;
    public $expirationDate;
    public $cvv;
    public $cardHolderName;

    public function rules()
    {
        // TODO: Set the messages in language files
        return [
            [['package', 'cardNumber', 'expirationDate', 'cardHolderName'], 'required'],
            ['cardNumber', 'string', 'length' => [19, 19]],
            ['expirationDate', 'string', 'length' => [5, 5]],
            ['cardHolderName', 'match', 'pattern' => '/^[a-zA-ZÇŞĞÜÖİçşğüöı  ]+$/'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'package' => Yii::t('auth', 'Package'),
            'cardNumber' => Yii::t('auth', 'Card Number'),
            'expirationDate' => Yii::t('auth', 'Expiration Date'),
            'cvv' => Yii::t('auth', 'Cvv'),
            'cardHolderName' => Yii::t('auth', 'Card Holder Name'),
        ];
    }


}
