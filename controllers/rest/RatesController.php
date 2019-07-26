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
use devskyfly\yiiModuleIitUc\components\StocksManager;

class RatesController extends AbstractRatesController
{
    public function actionIndex(array $ids = null)
    {
        try {
            if (!Vrbl::isNull($ids)) {
                //Chain
                $result = $this->getChain($ids);
            } else {
                //All rates
                $rates = Rate::find()
                ->where(['active' => 'Y'])
                ->all();
                
                foreach ($rates as $rate) {

                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        "slx_id" => $rate->slx_id,
                        "price" => Nmbr::toDoubleStrict($rate->price),
                    ];
                }
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

    public function actionCalc()
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
                        //"calc_sort" =>,
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
