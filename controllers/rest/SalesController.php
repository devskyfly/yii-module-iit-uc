<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\SalesList;
use Yii;
use yii\web\NotFoundHttpException;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\components\RatesChainBuilder;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\OrderBuilder;

class SalesController extends CommonController
{
    public function actionIndex(array $ids)
    {
        try {
            $chain = [];
            
            //Models definition
            foreach ($ids as $id) {
                $rate = RatesManager::getBySlxId($id);
                if (!Vrbl::isNull($rate)) {
                    $rates[] = $rate;
                } else {
                    throw NotFoundHttpException('Model with id=\'' . $id . '\' does not exist.');
                }
            }

            array_unique($rates);
            $promoListCmp = new PromoList();
            $bindListCmp = new BindsList();
            $salesCmp =new SalesList();
            //throw new \Exception(print_r($bindListCmp,true));
            //throw new \Exception($promoListCmp::class);
            $ratesChainCmp = new OrderBuilder([
                'rates'=>$rates,
                'promoListCmp'=>$promoListCmp,
                'bindListCmp'=>$bindListCmp,
                'salesListCmp'=>$salesCmp
            ]);

            $chain = $ratesChainCmp->build()->getRatesChain();

            
            $this->asJson([
                'sale' => $ratesChainCmp->sale
            ]);
        } catch (\Exception $e) {
            Yii::error($e, self::class);
            throw $e;
            //throw new NotFoundHttpException();
        }
    }    
}