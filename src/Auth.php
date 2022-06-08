<?php

namespace vademecumas\auth;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * id module definition class
 */
class Auth extends \yii\base\Module implements BootstrapInterface
{

    public $enableRegister = false;
    public $shouldVerifyEmail = false;
    public $dataSource = self::DATA_SOURCE_DB;

    const  DATA_SOURCE_API = 'api';
    const  DATA_SOURCE_DB = 'db';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'vademecumas\auth\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

    }

    public function bootstrap($app)
    {

        if ($this->dataSource == self::DATA_SOURCE_API) {
            $appPath = Yii::getAlias('@app');
            $authConfigPath = $appPath . '/config/auth.php';
            $authLoaclConfigPath = $appPath . '/config/auth-local.php';

            if (file_exists($authConfigPath)) {
                Yii::configure($this, require($authConfigPath));
            }
            if (file_exists($authLoaclConfigPath)) {
                Yii::configure($this, require($authLoaclConfigPath));
            }
        }

        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'vademecumas\auth\commands';
        } else {
            $this->controllerNamespace = 'vademecumas\auth\controllers';
        }
    }
}
