<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * Provides binding rates on rate select.
 * 
 * @author devskyfly
 *
 */
class BindsList extends AbstractRatesAsset
{
    /**
     *
     * @return []]
     */
    public function initIdsList()
    {
        return Yii::$app->params['iit-uc']['binds-list']['idsList'];
    }
    
     /**
     * Apply binds on $models
     * 
     * @param Rate[] $models
     * @throws \InvalidArgumentException
     * @return Rate[]
     */
    public function apply($models)
    {
        $binds=$models;
        
        foreach ($models as $model){
            if(!Obj::isA($model, Rate::class)){
                throw new \InvalidArgumentException('Item $models is not '.Rate::class.' type.');
            }
        }
        
        foreach ($this->list as $item){
            if(in_array($item['master'], $models)){
                $binds=ArrayHelper::merge($binds,$item['slave']);
            }
        }
        $binds=array_unique($binds); 
        
        return $binds;
    }
}