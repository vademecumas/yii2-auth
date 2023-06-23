<?php

use yii\db\Migration;

class m120524_201442_users_table extends Migration
{
    public function up()
    {

        $this->createTable($this->tableName(), [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'verification_token' => $this->string()->defaultValue(null),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

    }

    public function down()
    {
        $this->dropTable($this->tableName());
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
