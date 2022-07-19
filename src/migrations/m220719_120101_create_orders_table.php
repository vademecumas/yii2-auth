<?php

use yii\db\Schema;

class m220719_120101_create_orders_table extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'delivery_city' => $this->integer(),
            'delivery_address' => $this->string(),
            'billing_address' => $this->string(),
            'tc_no' => $this->bigInteger(),
            'company_name' => $this->string(),
            'company_tax_no' => $this->string(),
            'company_tax_office' => $this->string(),
            'payment_type' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'payment_status' => $this->boolean()->notNull()->defaultValue(false),
            'payment_error' => $this->string(),
            'bill_type' => $this->integer(),
            'amount' => $this->double()->notNull(),
            'total_amount' => $this->double(),
            'ip_address' => $this->string(),
            'billing_city' => $this->integer(),
            'shipping_price' => $this->double(),
            'package_id' => $this->integer(),
            'card_token' => $this->string(),
            'card_user_key' => $this->string(),
            'order_status' => $this->integer(),
            'vdmcid_order_identifier' => $this->string(255),
        ]);

    }

    public function down()
    {
        $this->dropTable('orders');
    }
}
