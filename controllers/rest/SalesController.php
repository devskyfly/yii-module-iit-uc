<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

class SalesController extends CommonController
{
    public function actionIndex()
    {
        $this->asJson(['sale'=>0]);
    }    
}