<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\helpers\ArrayHelper;

/**
 * Provide make promo company on some  assets of rates.
 * 
 * @author devskyfly
 *
 */
class PromoList extends BaseObject
{
    public $list=[];
    
    public $rates=[];
    
    /**
     *
     * {@inheritDoc}
     * @see \yii\base\BaseObject::init()
     * @throws \InvalidArgumentException
     */
    public function init()
    {
        parent::init();
        
        if(Vrbl::isEmpty($this->rates)){
            $this->initRates();
        }
        
        if(Vrbl::isEmpty($this->list)){
            $this->initList();
        }
    }
    
    public function initList()
    {
        $this->list=[
            [
                "asset" => [$this->rates['AETP'],$this->rates['FETP']],
                "change" => [$this->rates['AETP_PL_FETP']]
            ],
        ];
    }
    
    public function initRates()
    {
        $this->rates=[];
        $this->rates['AETP']=RatesManager::getBySlxId('Y6UJ9A0000XM');       
        $this->rates['FETP']=RatesManager::getBySlxId('Y6UJ9A0000XL');
        $this->rates['AETP_PL_FETP']=RatesManager::getBySlxId('Y6UJ9A0000XN');
        
        foreach ($this->rates as $key => $rate){
            if(!Obj::isA($rate, Rate::class)){
                throw new \InvalidArgumentException("Array rates['{$key}'] is not ".Rate::class." type");
            }
        }
        
        return $this;
    }
    
    /**
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