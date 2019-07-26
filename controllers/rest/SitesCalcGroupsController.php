<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\StocksManager;

class SitesCalcGroupsController extends CommonController
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
                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        "slx_id" => $rate->slx_id,
                        "price" => Nmbr::toDoubleStrict($rate->price),
                        "stock" => $stock->stock,
                        "calc_name" =>$rate->calc_name,
                        //"calc_group" =>,
                        "calc_show" => true,
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
