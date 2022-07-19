<?php

namespace vademecumas\auth\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property integer $delivery_city
 * @property string $delivery_address
 * @property string $billing_address
 * @property integer $tc_no
 * @property string $company_name
 * @property string $company_tax_no
 * @property string $company_tax_office
 * @property integer $payment_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $payment_status
 * @property string $payment_error
 * @property integer $bill_type
 * @property double $amount
 * @property double $total_amount
 * @property string $ip_address
 * @property integer $billing_city
 * @property double $shipping_price
 * @property integer $package_id
 * @property string $card_token
 * @property string $card_user_key
 * @property integer $order_status
 *
 * @property GeneralBillType $billType
 * @property GeneralCity $deliveryCity
 * @property GeneralCity $billingCity
 * @property GeneralPaymentType $paymentType
 * @property KeyCompanyPackages $package
 * @property OrdersTypes $orderType
 * @property OrdersKeys[] $ordersKeys
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'phone', 'delivery_address', 'billing_address', 'company_name', 'company_tax_no', 'company_tax_office', 'payment_error', 'ip_address', 'card_token', 'card_user_key'], 'string'],
            [['delivery_city', 'tc_no', 'payment_type', 'created_at', 'updated_at', 'bill_type', 'billing_city', 'package_id', 'order_status'], 'integer'],
            [['payment_status'], 'boolean'],
            [['amount', 'total_amount', 'shipping_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'phone' => 'Phone',
            'delivery_city' => 'Delivery City',
            'delivery_address' => 'Delivery Address',
            'billing_address' => 'Billing Address',
            'tc_no' => 'Tc No',
            'company_name' => 'Company Name',
            'company_tax_no' => 'Company Tax No',
            'company_tax_office' => 'Company Tax Office',
            'payment_type' => 'Payment Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'payment_status' => 'Payment Status',
            'payment_error' => 'Payment Error',
            'bill_type' => 'Bill Type',
            'amount' => 'Amount',
            'total_amount' => 'Total Amount',
            'ip_address' => 'Ip Address',
            'billing_city' => 'Billing City',
            'shipping_price' => 'Shipping Price',
            'package_id' => 'Package ID',
            'card_token' => 'Card Token',
            'card_user_key' => 'Card User Key',
            'order_status' => 'Order Status',
        ];
    }


    public function getFullDeliveryAddress()
    {
        return $this->delivery_address . " " . $this->deliveryCity->name;
    }

    public function getFullBillingAddress()
    {
        return $this->billing_address . " " . $this->billingCity->name;
    }

    public function getFullName()
    {
        return $this->name . " " . $this->surname;
    }
}
