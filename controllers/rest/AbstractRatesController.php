<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\yiiModuleIitUc\components\OrderBuilder;

/**
 * Provide only getChainMetode
 */
abstract class AbstractRatesController extends CommonController
{
    /**
     * Return rates chain and apply promo, bind, sales to it.
     *
     * @param array $ids
     * @return devskyfly\yiiModuleIitUc\Rate[]
     */
    protected function getChain(array $ids = null)
    {
        $rates=[];
        $result=[];
        
        //Models definition
        foreach ($ids as $id) {
            $rate = RatesManager::getBySlxId($id);
            if (!Vrbl::isNull($rate)) {
                $rates[] = $rate;
            } else {
                throw NotFoundHttpException('Model with id=\'' . $id . '\' does not exist.');
            }
        }

        $promoListCmp = new PromoList();
        $bindListCmp = new BindsList();
        $salesCmp =new SalesList();
        
        $ratesChainCmp = new OrderBuilder([
            'rates'=>$rates,
            'promoListCmp'=>$promoListCmp,
            'bindListCmp'=>$bindListCmp,
            'salesListCmp'=>$salesCmp,
            'emmiter'=>OrderBuilder::EMMITERS[0]
        ]);

        $result = $ratesChainCmp->build()->getRatesChain();
        return $result;
    }
}
