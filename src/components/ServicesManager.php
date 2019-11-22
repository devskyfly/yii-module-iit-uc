<?php
namespace devskyfly\yiiModuleIitUc\components;


use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use devskyfly\yiiModuleIitUc\models\rate\RateToExcludedServiceBinder;

class ServicesManager extends BaseObject
{
/*     /**
     * 
     * @param Rate[] $models
     * @return Service[]
     */
    /* public static function getIncludedByRateChain($models)
    {
        $services=[];
        foreach ($models as $model){
            $list=static::getInclededByRate($model);
            $services=ArrayHelper::merge($services,$list);
        }
        $services=array_unique($services);
        return $services;
    } */
    
    /**
     * 
     * @param Rate[] $models
     * @return Service[]
     */
    public static function getExcludedByRateChain($models)
    {
        $services=[];
        foreach ($models as $model){
            $list=static::getExcludedByRate($model);
            $services=ArrayHelper::merge($services,$list);
        }
        $services=array_unique($services);
        return $services;
    }

    
    /**
     * 
     * @param Rate $model
     * @throws \InvalidArgumentException
     * @return Service[]
     */
    /* public static function getIncludedByRate($model)
    {
        if(!Obj::isA($model, Rate::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
        $services=RateToIncludedService::getSlaveItems($model->id);
        return $services;
    } */
    
    /**
     * 
     * @param Rate $model
     * @throws \InvalidArgumentException
     * @return Service[]
     */
    public static function getExcludedByRate($model)
    {
        if(!Obj::isA($model, Rate::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
        $services=RateToExcludedServiceBinder::getSlaveItems($model->id);
        return $services;
    }
}