<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerBinder;
use yii\helpers\ArrayHelper;

class ServicesManager extends BaseObject
{
    
    public static function getInclededByRate($model)
    {
        if(!Obj::isA($model, Rate::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
    }
    
    public static function getExcluded($model)
    {
        if(!Obj::isA($model, Rate::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
    }
}