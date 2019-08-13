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
use devskyfly\yiiModuleIitUc\models\rateCalcGroup\RateCalcGroup;

/**
 * Rest api class
 */
class RatesCalcController extends AbstractRatesController
{
    /**
     * Return rates
     * 
     * GET
     * 
     * Return:
     * [
     *  [
     *      id: number,
     *      name: string,
     *      slx_id: string,
     *      stock: number,
     *      price: number,
     *      calc_name: string,
     *      calc_sort: string,
     *      calc_group: number,
     *  ],...
     * ]
     */
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
                    $mapFn = function ($it) {
                        return Nmbr::toInteger($it);
                    };
                    $groupIds = array_map($mapFn, $groupIds);

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
                        "calc_group" => $groupIds,
                        "calc_sort" => Nmbr::toInteger($rate->calc_sort),
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

    /**
     * Return rates calc groups
     * 
     * GET
     * 
     * Return:
     * [
     *  [
     *      id: number,
     *      name: string,
     *      calc_sort: string
     *  ],...
     * ]
     */
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
