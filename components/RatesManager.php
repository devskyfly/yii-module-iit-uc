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
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use yii\base\InvalidArgumentException;

/**
 * Provides managing rates.
 * 
 * @author devskyfly
 *
 */
class RatesManager extends BaseObject
{
    public static function getBaseRate()
    {
        return self::getBySlxId("Y6UJ9A0000XK");
    } 

    public static function getFizRate()
    {
        return self::getBySlxId("Y6UJ9A0002C0");
    }
    
    /**
     * 
     * @param Rate $model
     * @throws InvalidArgumentException
     */
    public static function checkModel($model)
    {
        if(!Obj::isA($model, Rate::class)){
            throw new InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getChain($model,PromoList $promoList=null, BindsList $bindsList=null)
    {
        $result=[];
        self::checkModel($model);
        
        $result[]=$model;
        $parent=$model;
        
        while($parent=self::getParent($parent))
        {
            $result[]=$parent;
        }
        
        if($promoList)$result=$promoList->apply($result);
        if($bindsList)$result=$bindsList->apply($result);
        
        return Arr::reverse($result);
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $models
     * @throws InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getMultiChain($models, PromoList $promoList=null, BindsList $bindsList=null)
    {
        $result=[];
        if(!Arr::isArray($models)){
            throw new InvalidArgumentException('Parameter $models is not array type.');
        }
        $main=null;
        $list=[];
        foreach ($models as $model){
            $chain=self::getChain($model);
            foreach ($chain as $item){
                if(!Vrbl::isEmpty($item->_stock__id)){
                    $main=$item;
                    continue;
                }
                $list[$item->id]=$item;
            }
        }
        $result[]=$main;
        $result=ArrayHelper::merge($result, $list);
        if($promoList)$result=$promoList->apply($result);
        if($bindsList)$result=$bindsList->apply($result);
        
        return $result;
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate|NULL
     */
    public static function getParent($model)
    {
        self::checkModel($model);
        $id=$model->__id;
        return Rate::findOne(['active'=>'Y','id'=>$id]);
    }
    
    /**
     * 
     * @param Rate $model
     * @return [['item'=>...,sublist=>]]
     */
    public static function getAllChilds($model=null)
    {
        $result=[];
        $parent_id=0;
        if(!Vrbl::isNull($model)){
            self::checkModel($model);
            $parent_id=$model->__id;
        }else{
            $parent_id=null;
        }
        
        $list=static::getChilds($model);
        
        foreach ($list as $item){
            $result[]=['item'=>$item,'sublist'=>static::getAllChilds($item)];  
        }
        
        return $result;
    }
    
    /**
     * 
     * @param Rate|null $model
     * @return Rate[]
     */
    public static function getChilds($model=null)
    {   
        $parent_id=0;
        if(!Vrbl::isNull($model)){
            self::checkModel($model);
            $parent_id=$model->id;
        }else{
            $parent_id=null;
        }
        
        $result=Rate::find()->where(['__id'=>$parent_id])->all();
        return $result;
    }
    
    
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\power\Power[]
     */
    public static function getPowers($model)
    {
        self::checkModel($model);
        $list=RateToPowerBinder::getSlaveItems($model->id);
        return $list;
    }
    
    /**
     * 
     * @param string $slx_id
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate|NULL
     */
    public static function getBySlxId($slx_id)
    {
        if(!Str::isString($slx_id)){
            throw new \InvalidArgumentException('Parameter $slx_id is not string type.');
        }
        return Rate::findOne(['active'=>'Y','slx_id'=>$slx_id]);
    }

    /**
     * 
     * @param Rate $model
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return number
     */
    public static function getCost($model)
    {
        
        $cost=0;
        $chain=static::getChain($model);
        
        foreach ($chain as $item){
            $cost=$cost + $item->price;
        }
        
        return $cost;
    }

    /**
     *
     * @param Rate $model
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @return Rate
     */
    public static function getRootRate($model)
    {
        if (!Obj::isA($model, Rate::class)) {
            throw new \InvalidArgumentException('Param $model is not '.Rate::class.' type.');
        }

        $arr = self::getChain($model);

        if (Vrbl::isEmpty($arr)
            || (!Arr::isArray($arr))
        ) {
            throw new InvalidArgumentException('Variable $arr is not .');
        } 

        $root_rate = $arr[0];
        return $root_rate;
    }
 
}