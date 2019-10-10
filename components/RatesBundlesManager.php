<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\helpers\ModelsFilter;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundleToExtendedRatesBinder;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use yii\base\BaseObject;

/**
 * Provides managing rates bundles.
 * 
 * @author devskyfly
 *
 */
class RatesBundlesManager extends BaseObject
{
    /**
     *
     * @param \devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle $model
     * @throws \InvalidArgumentException
     * @return void
     */
    public static function checkModel($model)
    {
        if(!Obj::isA($model, RateBundle::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.RateBundle::class.' type.');
        }
    }

    /**
     *
     * @param string $slx_id
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle|NULL
     */
    public static function getBySlxId($slx_id)
    {
        if(!Str::isString($slx_id)){
            throw new \InvalidArgumentException('Parameter $slx_id is not string type.');
        }
        return RateBundle::findOne(['active'=>'Y','slx_id'=>$slx_id]);
    }

    /**
     *
     * @param \devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle $model
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\stock\Stock|NULL
     */
    public static function getStock($model)
    {
        static::checkModel($model);
        $id = $model->_stock__id;
        return Stock::findOne(['active'=>'Y','id'=>$id]);
    }

    /**
     *
     * @param \devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle $model
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate|NULL
     */
    public static function getParentRate($model)
    {
        static::checkModel($model);
        $parent_id = $model->_parent_rate__id;
        return Rate::findOne(['active'=>'Y','id'=>$parent_id]);
    }

    /**
     *
     * @param \devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle $model
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getBundleExtendedRates($model)
    {
        static::checkModel($model);
        $items = RateBundleToExtendedRatesBinder::getSlaveItems($model->id);
        $items = ModelsFilter::getActive($items);
        return $items;
    }

    /**
     * Undocumented function
     *
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $extended_rates
     * @param integer $intersect_size
     * @return \devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle[]
     */
    public function getRatesBundlesByExtendedRates(array $extended_rates, $intersect_size =2)
    {
        if (!Nmbr::isNumeric($intersect_size)) {
            throw new \InvalidArgumentException('Param $intersect_size is not numeric type.');
        }
        if (!is_array($extended_rates)) {
            throw new \InvalidArgumentException('Param $extended_rates is not array type.');
        }
        foreach ($extended_rates as $extended_rate) {
            RatesManager::checkModel($extended_rate);
        }

        $result = [];
        $bundles = RateBundle::find()->where(['active'=>'Y'])->all();

        foreach ($bundles as $bundle) {
            $rates = static::getBundleExtendedRates($bundle);
            $intersect = array_intersect($extended_rates, $rates);
            if (count($intersect)>=$intersect_size) {
                $diff = array_diff($extended_rates, $intersect);
                $result[] =  $bundle;
            }
        }
        return $result;
    }

    /**
     *
     * @param \devskyfly\yiiModuleIitUc\models\ratebundle\RateBuble $model
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate[] $extensions
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public function getRateBundlePosibleExtensions($model, $extensions)
    {
        /*$result = [];
        static::checkModel($model);
        $parent_rate = static::getParentRate($model);

        if (Vrbl::isNull($parent_rate)) {
            throw new \RuntimeException('Parent rate variable points to null.');
        }

        $child_rates = RatesManager::getListAllChilds($parent_rate);
        $bundle_rates = static::getBundleExtendedRates($model);
        
        $callback = function ($item) {
            if (Vrbl::isNull($item)) {
                return false;
            }

            if ($item->active == 'Y') {
                return true;
            } else {
                return false;
            }
        };
        
        $child_rates = array_filter($child_rates, $callback);
        $bundle_rates = array_filter($bundle_rates, $callback);

        $child_rates_without_bundle_rates = array_diff($child_rates, $bundle_rates);
        $clear_extensions = array_diff($extensions, $bundle_rates);

        //$result = array_intersect($clear_extensions, $child_rates_without_bundle_rates);
        $result = array_unique($clear_extensions);
        return $result;*/
    }

    /**
     *
     * @param \devskyfly\yiiModuleIitUc\models\ratebundle\RateBuble $model
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate[] $extensions
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public function getRateBundleAdditionalRates($model, $extensions)
    {
        $result = [];
        static::checkModel($model);
        $parent_rate = static::getParentRate($model);
       
        if (Vrbl::isNull($parent_rate)) {
            throw new \RuntimeException('Parent rate variable points to null.');
        }

        $child_rates = RatesManager::getListAllChilds($parent_rate);
        $bundle_rates = static::getBundleExtendedRates($model);
        
        $child_rates = ModelsFilter::getActive($child_rates);
        $bundle_rates = ModelsFilter::getActive($bundle_rates);

        $diff = array_diff($extensions, $bundle_rates);
        $result = $diff;
        /*$intersect = array_intersect($diff, $child_rates);
        $result = $intersect;*/
        return $result;
    }
}