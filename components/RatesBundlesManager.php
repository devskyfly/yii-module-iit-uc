<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundleToExtendedRatesBinder;

/**
 * Provides managing rates bundles.
 * 
 * @author devskyfly
 *
 */
class RatesBundlesManager extends BaseObject
{
    public static function checkModel($model)
    {
        if(!Obj::isA($model, RateBundle::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.RateBundle::class.' type.');
        }
    }

    public static function getBySlxId($slx_id)
    {
        if(!Str::isString($slx_id)){
            throw new \InvalidArgumentException('Parameter $slx_id is not string type.');
        }
        return RateBundle::findOne(['active'=>'Y','slx_id'=>$slx_id]);
    }

    public static function getParentRate($model)
    {
        static::checkModel($model);
        $parent_id = $this->_parent_rate_id;
        return Rate::findOne(['active'=>'Y','id'=>$parent_id]);
    }

    public static function getExtendedRatesByBundle($model)
    {
        static::checkModel($model);
        $items = RateBundleToExtendedRatesBinder::getSlaveItems($model->id);
        $callback = function($item){
            if((!Vrbl::isNull($item))&&($item->active=="Y")){
                return true;
            }
            return false;
        };
        $items = array_filter($items, $callback);
        return $items;
    }

    public function getRatesBundlesByExtendedRates(array $extended_rates)
    {
        if (!is_array($extended_rates)) {
            throw new \InvalidArgumentException('Param $extended_rates is not array type.');
        }
        
        foreach ($extended_rates as $extended_rate) {
            Rate::checkModel($extended_rate);
        }

        $result = [];
        $bundles = RateBundle::find()->where(['active'=>'Y'])->all();

        foreach ($bundles as $bundle) {
            $rates = static::getExtendedRatesByBundle($bundle);
            $intersect = array_intersect($extended_rates, $rates);
            if (count($intersect)>=2) {
                $diff = array_diff($extended_rates, $intersect);
                $result[] = ["bundle" => $bundle, "extensions" =>$diff];
            }
        }
        return $result;
    }
}