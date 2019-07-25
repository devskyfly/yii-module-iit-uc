<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\yiiModuleIitUc\components\OrderBuilder;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

abstract class AbstractRatesController extends CommonController
{
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
            'salesListCmp'=>$salesCmp
        ]);

        $result = $ratesChainCmp->build()->getRatesChain();
        return $result;
    }
}
