<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\SalesList;
use Yii;
use yii\web\NotFoundHttpException;

class SalesController extends CommonController
{
    public function actionIndex(array $ids)
    {
        try {
            $result = [];
            
            $models = [];
            foreach ($ids as $id) {
                $models[] = RatesManager::getBySlxId($id);
            }
            
            $chain = RatesManager::getMultiChain($models);
            $sale = (new SalesList())->count($chain);
            $this->asJson([
                'sale' => $sale
            ]);
        } catch (\Exception $e) {
            Yii::error($e, self::class);
            throw new NotFoundHttpException();
        }
    }    
}