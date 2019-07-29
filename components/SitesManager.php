<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\RateToSiteBinder;
use devskyfly\yiiModuleIitUc\models\site\Site;
use yii\helpers\ArrayHelper;
use devskyfly\yiiModuleIitUc\components\RatesManager;

/**
 * Provides managing sites and them bindings to rates.
 * 
 * @author devskyfly
 *
 */
class SitesManager extends BaseObject
{
    /**
     *
     * @param Rate $model
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function checkModel($model)
    {
        if(!Obj::isA($model, Site::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
        /* if($model->isNewRecord){
            throw new \RuntimeException('Item $model does not exist in data base.');
        } */
    }
    
    /**
     * 
     * @param Site $model
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getRates($model)
    {
        $chain=[];
        static::checkModel($model);
        $rates=RateToSiteBinder::getMasterItems($model->id);
        if(!Vrbl::isEmpty($rates)){
            $chain=RatesManager::getMultiChain($rates);
        }
        return $chain;
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws \InvalidArgumentException
     * @return number[]
     */
    public static function getIdsByRate($model)
    {
        RatesManager::checkModel($model);
        return RateToSiteBinder::getSlaveIds($model->id);
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model $model
     * @return \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem[]
     */
    public static function getByRate($model)
    {
        RatesManager::checkModel($model);
        return RateToSiteBinder::getSlaveItems($model->id);
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @return Generator
     */
    public static function getChainSites($model)
    {
        $ids=[];
        RatesManager::checkModel($model);
        $chain=RatesManager::getChain($model);
        
        foreach($chain as $item){
            $ids=ArrayHelper::merge($ids, self::getIdsByRate($item));        
        }
        $ids=array_unique($ids);
        $query=Site::find()->where(['id'=>$ids])->orderBy(['name'=>SORT_ASC]);
        
        foreach ( $query->each() as $item){
            yield $item;
        }
    }

    public static function getCheepRate($model)
    {
        if (!Obj::isA($model, Site::class)) {
            throw new \InvalidArgumentException('Param $model is not '.Site::class.' type.');
        }
        $rates = self::getRates($model);

        if (Vrbl::isEmpty($rates)) {
            return null;
        }   

        
        $priceTable=[];
        foreach($rates as $itm){
            $cost=RatesManager::getCost($itm);
            $priceTable[]=[
                "cost"=>$cost,
                "rate"=>$itm
            ];
        }

        $sortFnc=function($a, $b){
            if ($a["cost"] == $b["cost"]) {
                return 0;
            }
            return ($a["cost"] < $b["cost"]?-1:1);
        };

        $result=usort($priceTable,$sortFnc);

        if(!$result){
            throw new \RuntimeException('usort execution crashed.');
        }
        
        $rate = $priceTable[0];

        if ($rate = RatesManager::getFizRate()) {
            return RatesManager::getBaseRate();
        }
    }
}