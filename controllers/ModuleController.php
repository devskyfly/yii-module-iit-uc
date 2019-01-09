<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use yii\web\Controller;

class ModuleController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
