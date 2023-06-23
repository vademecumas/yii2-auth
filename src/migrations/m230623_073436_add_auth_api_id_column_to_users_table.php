<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m230623_073436_add_auth_api_id_column_to_users_table extends Migration
{
    public function up()
    {
        $this->addColumn($this->tableName(), 'auth_api_id', $this->bigInteger());
    }

    public function down()
    {
        $this->dropColumn($this->tableName(), 'auth_api_id');
    }

    protected function tableName()
    {
        $authModule = Yii::$app->getModule('auth');
        if (isset($authModule->dbSchema)) {
            return $authModule->dbSchema . '.users';
        }
        return 'users';
    }
}
