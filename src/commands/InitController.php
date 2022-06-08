<?php

namespace vademecumas\auth\commands;

use vademecumas\auth\Auth;
use vademecumas\auth\helpers\Dir;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class InitController extends Controller
{
    public function actionIndex($appDirectory)
    {
        $appDir = Yii::getAlias($appDirectory);

        if (Yii::$app->getModule('auth')->dataSource == Auth::DATA_SOURCE_API) {
            //copy config files
            Dir::copy(__DIR__ . "/../config", $appDir . "/config");
        }

        //copy mail templates
        Dir::copy(__DIR__ . "/../mail", $appDir . "/mail");

        //copy message files
        Dir::copy(__DIR__ . "/../messages", $appDir . "/messages");

        //copy view files
        Dir::copy(__DIR__ . "/../views", $appDir . "/views/auth");

    }
}