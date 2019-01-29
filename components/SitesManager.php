<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Arr;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\RateToSiteBinder;
use devskyfly\yiiModuleIitUc\models\site\Site;
use yii\helpers\ArrayHelper;

class SitesManager extends BaseObject
{
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
}