<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\powerPackage\PowerPackage;
use devskyfly\yiiModuleIitUc\models\powerPackage\PowerPackageToPowerBinder;

/**
 * Provides manager for binding rates, powers, and powerspackages.
 * @author devskyfly
 *
 */
class PowersManager extends BaseObject
{
    public static function getGroupedList($model)
    {
        $list=[];
        if(!Obj::isA($model,Rate::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
        $packeges=static::getPackages($model);
        
        foreach ($packeges as $package){
            $powers=static::getPowers($package);
            $list[]=['package'=>$package,'powers'=>$powers];
        }
        
        return $list;
    }
    
    public static function getPackages($model)
    {
        
        if(!Obj::isA($model,Rate::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
        
        $binds=RateToPowerPackageBinder::getSlaveItems($model->id);
        return $binds;
    }
    
    public static function getPowers($model)
    {
        if(!Obj::isA($model,PowerPackage::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.PowerPackage::class.' type.');
        }
        
        $binds=PowerPackageToPowerBinder::getSlaveItems($model->id);
        return $binds;
    }
}