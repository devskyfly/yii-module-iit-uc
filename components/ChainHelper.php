<?php
namespace devskyfly\yiiModuleIitUc\components;

use yii\base\BaseObject;
use yii\helpers\Json;
use devskyfly\php56\libs\arr\Intersect;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle;
use devskyfly\yiiModuleIitUc\models\stock\Stock;

class ChainHelper  extends BaseObject
{
    public static function getClientTypes($rates)
    {
        $client_types_arr = [];

        foreach ($rates as $item) {
            $client_types_arr = array_merge($client_types_arr, [Json::decode($item->client_type)]);
        }

        return Intersect::getIntersectOfArrayItems($client_types_arr);
    }

    public static function formChainToApiFormat($rates)
    {
        $result = [];
        $client_types = static::getClientTypes($rates);

        $itr = 0;
        foreach ($rates as $rate) {
            $itr++;

            //Stock
            $stock = null;
            if (!Vrbl::isEmpty($rate->_stock__id)) {
                $stock = Stock::find()
                    ->where([
                        'active' => Stock::ACTIVE,
                        'id' => $rate->_stock__id
                    ])
                    ->one();

                if (Vrbl::isEmpty($stock)) {
                    throw new \RuntimeException('Parameter $stock is empty.');
                }
            }

            $powers_packages_ids = [];
            $rates_packages_ids = [];

            $powersPackages = RateToPowerPackageBinder::getSlaveItems($rate->id);
            
            $ratePackage = null;
            
            if (Obj::isA($rate, Rate::class)) {
                $ratePackage = RatePackageManager::getByRate($rate);
            }

            if ($ratePackage) {
                $rates_packages_ids[]=$ratePackage->id;
            }

            //Powers packages definition
            foreach ($powersPackages as $powerPackage) {
                if ($powerPackage->active == 'Y') {
                    $powers_packages_ids[] = $powerPackage->id;
                }
            }

            $result[]=[
                "id"=>(Obj::isA($rate, RateBundle::class))?(1000+$rate->id):$rate->id,
                "name"=>$rate->name,
                "calc_name"=>$rate->calc_name,
                "slx_id"=>$rate->slx_id,
                "price"=>Nmbr::toDoubleStrict($rate->price),
                "powers_packages"=>$powers_packages_ids,
                "rates_packages"=>$rates_packages_ids,
                "required_powers"=>[],
                "stock_id"=>Vrbl::isNull($stock)?'':$stock->stock,
                "stock_bind_id"=>Vrbl::isNull($stock)?'':$stock->id,
                "client_types"=>$itr==1?$client_types:[],
                "required_license"=>$rate->flag_for_license=='Y'?true:false
            ];
        }

        return $result;
    }
}