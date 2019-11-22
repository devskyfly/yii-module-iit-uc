<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use yii\web\Controller;
use devskyfly\yiiModuleIitUc\Module;
use devskyfly\yiiModuleIitUc\models\common\ModuleNavigation;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $title=Module::TITLE;
        $module_navigation=new ModuleNavigation();
        $list=[$module_navigation->getData()];
        return $this->render('index',compact("list","title"));
    }
}