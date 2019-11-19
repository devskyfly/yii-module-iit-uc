<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\order\RateOrderBuilder;
use devskyfly\yiiModuleIitUc\helpers\ModelsFilter;

/**
 * Rest api class
 */
class SalesController extends CommonController
{

    /**
     * Return sale on rates chain
     * GET
     * 
     * Return:
     * [
     *      sale:number
     * ]
     * 
     * @param number[] $ids
     * @return void
     */
    public function actionIndex(array $ids)
    {
        try {
            $rates = [];
            $chain = [];
            
            //Models definition
            foreach ($ids as $id) {
                $rate = RatesManager::getBySlxId($id);
                if (!Vrbl::isNull($rate)) {
                    $rates[] = $rate;
                } 
            }

            $rates = ModelsFilter::getActive($rates);
            array_unique($rates);
            
            if(!Vrbl::isEmpty($rates)){
                $promoListCmp = new PromoList();
                $bindListCmp = new BindsList();
                $salesCmp =new SalesList();
                
                $ratesChainCmp = new RateOrderBuilder([
                    'rates'=>$rates,
                    'promoListCmp'=>$promoListCmp,
                    'bindListCmp'=>$bindListCmp,
                    'salesListCmp'=>$salesCmp,
                    'emmiter'=>RateOrderBuilder::EMMITERS[1]
                ]);

                $chain = $ratesChainCmp->build()->getRatesChain();
                
                $this->asJson([
                    'sale' => $ratesChainCmp->sale
                ]);
            } else {
                $this->asJson([
                    'sale' => 0
                ]);
            }
            
            
        } catch (\Exception $e) {
            Yii::error($e, self::class);
            if (YII_DEBUG) {
                throw $e;
            } else {
                throw new NotFoundHttpException();
            }
        }
    }    
}