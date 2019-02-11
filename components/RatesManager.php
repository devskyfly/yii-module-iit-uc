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

class RatesManager extends BaseObject
{
    
    public static function checkModel($model)
    {
        if(!Obj::isA($model, Rate::class)){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
        if($model->isNewRecord){
            throw new \RuntimeException('Item $model does not exist in data base.');
        }
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getChain($model)
    {
        $result=[];
        self::checkModel($model);
        
        $result[]=$model;
        $parent=$model;
        
        while($parent=self::getParent($parent))
        {
            $result[]=$parent;
        }
        return Arr::reverse($result);
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $models
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getMultiChain($models)
    {
        $result=[];
        if(!Arr::isArray($models)){
            throw new \InvalidArgumentException('Parameter $models is not array type.');
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
        
        $promoList=new PromoList();
        $result=$promoList->apply($result);
        $binds=new BindsList();
        $result=$binds->apply($result);
        //new SalesList();
        
        return $result;
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate|NULL
     */
    public static function getParent($model)
    {
        self::checkModel($model);
        $id=$model->__id;
        return Rate::findOne(['active'=>'Y','id'=>$id]);
    }
    
    /**
     * @todo Nead to realize
     */
    public static function getRelatives($model)
    {
        self::checkModel($model);
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getChilds($model)
    {
        self::checkModel($model);
        $id=$model->id;
        return Rate::findAll(['active'=>'Y','__id'=>$id]);
    }
    
    /**
     * 
     * @param \devskyfly\yiiModuleIitUc\models\rate\Rate $model
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
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
}