<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\RatePackageManager;
use Yii;
use yii\helpers\Json;
use devskyfly\yiiModuleIitUc\components\RatesChainBuilder;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\yiiModuleIitUc\components\OrderBuilder;

class RatesController extends CommonController
{
    private function actionGetBySlxIds(array $ids)
    {
        $data = [];
        $rates_cls = Rate::class;

        if (!Arr::isArray($ids)) {
            throw new BadRequestHttpException('Query param \'ids\' is not array type.');
        }

        foreach ($ids as $id) {
            if (!Str::isString($id)) {
                throw new BadRequestHttpException('Query param \'id\' is not string type.');
            }

            $item = $rates_cls::find()
                ->where(
                    [
                        'active' => 'Y',
                        'slx_id' => $id
                    ]
                )
                ->one();

            if (Vrbl::isNull($item)) {
                throw new NotFoundHttpException("Rate with slx_id='{$id}' is not found.");
            }

            $data[] = [
                "id" => $item->id,
                "name" => $item->name,
                "price" => $item->price
            ];
        }

        $this->asJson($data);
    }

    private function actionGetChain($id)
    {

        $model = RatesManager::getBySlxId($id);
        $chain = RatesManager::getChain($model);
        $this->asJson($chain);
    }


    public function actionIndex(array $ids = null)
    {
        
        try {
            $rates=[];
            $result=[];
            if (!Vrbl::isNull($ids)) {
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

                $result = $ratesChainCmp->build()->getRatesChain();
                
            } else {
                //All rates
                $rates = Rate::find()->where(['active' => 'Y'])->all();
                foreach ($rates as $rate) {

                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        "slx_id" => $rate->slx_id,
                        "price" => Nmbr::toDoubleStrict($rate->price),
                        //"stock_id"=>Vrbl::isNull($stock)?'':$stock->stock,
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

    public function _actionIndex(array $ids = null)
    {
        try {
            if (!Vrbl::isNull($ids)) {
                $result = [];
                $models = [];
                $ratesPackages = [];

                //Models definition
                foreach ($ids as $id) {
                    $model = RatesManager::getBySlxId($id);
                    if (!Vrbl::isNull($model)) {
                        $models[] = $model;
                    } else {
                        throw NotFoundHttpException('Model with id=\'' . $id . '\' does not exist.');
                    }
                }

                //???
                array_unique($models);

                //Removing rates matched in rates.
                $modelCnt = Arr::getSize($models);
                for ($mdlItr = 0; $mdlItr < $modelCnt; $mdlItr++) {
                    $ratePackage = RatePackageManager::getByRate($models[$mdlItr]);
                    if (!Vrbl::isNull($ratePackage)) {
                        unset($models[$mdlItr]);
                        $parentRate = Rate::getById($ratePackage->_parent_rate__id);
                        if (Vrbl::isNull($parentRate)) {
                            throw new \RuntimeException('Parameter $parentRate is null.');
                        }
                        $models[] = $parentRate;
                        $ratesPackages[] = $ratePackage;
                    }
                }

                array_unique($models);

                $promoList = new PromoList();
                $bindsList = new BindsList();

                $chain = RatesManager::getMultiChain($models, $promoList, $bindsList);

                //Client type definition from rates.
                $client_types_arr = [];
                foreach ($chain as $item) {
                    $client_types_arr = array_merge($client_types_arr, [Json::decode($item->client_type)]);
                }

                $intersected_clients_types = $this->intersect($client_types_arr);

                
                $itr = 0;
                foreach ($chain as $item) {
                    $itr++;
                    $powersPackages = RateToPowerPackageBinder::getSlaveItems($item->id);
                    $powers_packages_ids = [];
                    $rates_packages_ids = [];

                    //Powers packages definition
                    foreach ($powersPackages as $powerPackage) {
                        if ($powerPackage->active == 'Y') {
                            $powers_packages_ids[] = $powerPackage->id;
                        }
                    }

                    //Rates packages definition
                    $ratesInPackages=[];
                    foreach ($ratesPackages as $ratePackage) {
                        if ($ratePackage->active == 'Y') {
                            $rates_packages_ids[] = $ratePackage->id;
                        }
                    }

                    $rates_packages_ids = array_unique($rates_packages_ids);

                    $stock = null;
                    if (!Vrbl::isEmpty($item->_stock__id)) {
                        $stock = Stock::find()
                            ->where([
                                'active' => Stock::ACTIVE,
                                'id' => $item->_stock__id
                            ])
                            ->one();

                        if (Vrbl::isEmpty($stock)) {
                            throw new \RuntimeException('Parameter $stock is empty.');
                        }
                    }

                    
                    $result[]=[
                        "id"=>$item->id,
                        "name"=>$item->name,
                        "slx_id"=>$item->slx_id,
                        "price"=>Nmbr::toDoubleStrict($item->price),
                        "powers_packages"=>$powers_packages_ids,
                        "rates_packages"=>$itr==1?$rates_packages_ids:[],
                        "required_powers"=>[],
                        "stock_id"=>Vrbl::isNull($stock)?'':$stock->stock,
                        "client_types"=>$itr==1?$intersected_clients_types:[],
                        "required_license"=>$item->flag_for_license=='Y'?true:false
                    ];
                }
            } else {
                //All rates
                $models = [];

                $rates = Rate::find()->where(['active' => 'Y'])->all();
                foreach ($rates as $rate) {

                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        "slx_id" => $rate->slx_id,
                        "price" => Nmbr::toDoubleStrict($rate->price),
                        //"stock_id"=>Vrbl::isNull($stock)?'':$stock->stock,
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
