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

class RatesController extends CommonController
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

    public function actionCalc(array $ids = null)
    {
        try {
            if (!Vrbl::isNull($ids)) {
                //Chain
                $result = $this->getChain($ids);

                $stock = null;

                foreach ($result as $item) {
                    $rate = Rate::getBySlxId($item['slx_id']);
                    if(Vrbl::isNull($rate)){
                        throw new InvalidArgumentException('Varible $rate is null.');
                    }
                    
                    $stock_id = Nmbr::toInteger($rate->_stock__id);
                    $stock = Stock::getById($stock_id);
                    if (!Vrbl::isNull($stock)) {
                        break;
                    }
                }

                if (Vrbl::isNull($stock)) {
                    throw new InvalidArgumentException('Varibale $stock is null.');
                }

                foreach ($result as &$item) {
                    $item['stock_id'] = $stock->stock;
                    //$item['stock_id'] = 15;
                }
                unset($item);
            } else {
                //All rates
                $rates = Rate::find()
                ->where(['active' => 'Y'])
                ->all();
                
                $stock = null;
                foreach ($rates as $rate) {
                    $stock_id = Nmbr::toInteger($rate->_stock__id);
                    $stock = Stock::getById($stock_id);
                    if (!Vrbl::isNull($stock)) {
                        break;
                    }
                }

                if (Vrbl::isNull($stock)) {
                    throw new InvalidArgumentException('Varibale $stock is null.');
                }

                foreach ($rates as $rate) {

                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        "slx_id" => $rate->slx_id,
                        "price" => Nmbr::toDoubleStrict($rate->price),
                        "stock" => 15
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
}
