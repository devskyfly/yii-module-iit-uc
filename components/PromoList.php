<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Provide make promo company on some assets of rates.
 *
 * @author devskyfly
 *        
 */
class PromoList extends AbstractRatesAsset
{

    /**
     *
     * @return []
     */
    public function initIdsList()
    {
        return Yii::$app->params['iit-uc']['promo-list']['idsList'];
    }
    
    /**
     * Apply promo on $models
     * 
     * @param Rate[] $models
     * @return array
     */
    public function apply($models)
    {
        $binds=[];
        $changes=[];
        
        foreach ($models as $model){
            if(!Obj::isA($model, Rate::class)){
                throw \InvalidArgumentException('Item $models is not '.Rate::class.' type.');
            }
        }
        
        foreach ($this->list as $item){
            $intersect=array_intersect($item['asset'],$models);
            $diff=array_diff($item['asset'],$intersect);
            if(Vrbl::isEmpty($diff)){
                foreach ($models as $key => $rate){
                    if(in_array($rate, $item['asset'])){
                        unset($models[$key]);
                    }
                }
                $changes=ArrayHelper::merge($changes, $item['change']);
            }
        }
        $binds=ArrayHelper::merge($models,$changes);
        $binds=array_unique($binds);
        
        return $binds;
    }
}