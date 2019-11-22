<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use Yii;
use yii\base\BaseObject;

/**
 * Provides making sales on rates.
 * 
 * @author devskyfly
 *
 */
class SalesList extends AbstractRatesAsset
{

    public function initIdsList()
    {
        return Yii::$app->params['iit-uc']['sales-list']['idsList'];
    }

    /**
     * 
     * @param Rate[] $models
     * @param Rate[] $asset
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public function match($models,$asset)
    {
        foreach ($models as $model){
            if(!Obj::isA($model, Rate::class)){
                throw new \InvalidArgumentException('Item $models is not '.Rate::class.' type.');
            }
        }
        
        foreach ($asset as $item){
            if(!Obj::isA($item, Rate::class)){
                throw new \InvalidArgumentException('Item $asset is not '.Rate::class.' type.');
            }
        }
        
        $intersect=array_intersect($asset,$models);
        $diff=array_diff($asset,$intersect);
        if(empty($diff)){
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param Rate[] $models
     * @throws \InvalidArgumentException
     * @return number
     */
    public function count($models)
    {
        $summ=0;
        foreach ($this->list as $item){
            if($this->match($models, $item['rates'])){
                if(!Nmbr::isNumeric($item['sale'])){
                    throw new \InvalidArgumentException('Item $item[\'sale\'] is not numeric type.');
                }
                $summ+=$item['sale'];
            }
        }
        return $summ;
    }
}