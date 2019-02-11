<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\SalesList;

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
        $sale=(new SalesList())->count($chain);
        $this->asJson(['sale'=>$sale]);
    }    
}