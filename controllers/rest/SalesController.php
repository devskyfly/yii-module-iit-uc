<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\yiiModuleIitUc\components\RatesManager;

class SalesController extends CommonController
{
    public function actionIndex(array $ids)
    {
        $result=[];
        
        $models=[];
        foreach ($ids as $id){
            $models[]=RatesManager::getBySlxId($id);
        }
        
        $chain=RatesManager::getMultiChain($models);
        
        $this->asJson(['sale'=>0]);
    }    
}