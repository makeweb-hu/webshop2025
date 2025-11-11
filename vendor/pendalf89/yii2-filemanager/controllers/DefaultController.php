<?php

namespace pendalf89\filemanager\controllers;

use Yii;
use app\components\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }
}
