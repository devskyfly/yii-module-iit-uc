<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\StocksManager;
use devskyfly\yiiModuleIitUc\models\rateCalcGroup\RateCalcGroupToRateBinder;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Arr;
use devskyfly\yiiModuleIitUc\models\rateCalcGroup\RateCalcGroup;

class RatesCalcController extends AbstractRatesController
{
    public function actionIndex()
    {
        try {
                $result=[];
                $rates = Rate::find()
                ->where(['active' => 'Y','flag_show_in_calc' => 'Y'])
                ->all();
                
                foreach ($rates as $rate) {
                    $rootRate = RatesManager::getRootRate($rate);
                    $stock = StocksManager::getStockByRate($rootRate);
                    $groupIds = RateCalcGroupToRateBinder::getMasterIds($rate->id);
                    
                    array_unique($groupIds);

                    if (Vrbl::isEmpty($groupIds)
                    //||(Arr::getSize($groupIds)>1)
                    ) {
                        continue;
                    }

                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        "slx_id" => $rate->slx_id,
                        "price" => Nmbr::toDoubleStrict($rate->price),
                        "stock" => $stock->stock,
                        "calc_name" =>!Vrbl::isEmpty($rate->calc_name)?$rate->calc_name:$rate->name,
                        "calc_group" => Nmbr::toIntegerStrict($groupIds[0]),
                        "calc_sort" => $rate->calc_sort,
                        
                    ];
                }
            
            $this->asJson($result);
        } catch (\Exception $e) {
            Yii::error($e, self::class);
            if (YII_DEBUG) {
                throw $e;
            } else {
                throw new NotFoundHttpException();
            }
        }
    }

    public function actionGroups()
    {
        $result = [];
        try {
            $items = RateCalcGroup::find()
            ->where(['active'=>'Y'])
            ->orderBy(['name'=>SORT_ASC,'sort'=>SORT_ASC])
            ->all();

            foreach ($items as $item) {
                $result[] = [
                    "id" => $item->id,
                    "name" => $item->name,
                    "calc_sort" => $item->sort,
                ];
            }

            $this->asJson($result);
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
