<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

class SalesController extends CommonController
{
    public function actionIndex()
    {
        $this->asJson(['sales'=>0]);
    }    
}