<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\helpers\ArrayHelper;

class PromoList extends BaseObject
{
    private $_list=[];
    
    private $_rates=[];
    
    /**
     *
     * {@inheritDoc}
     * @see \yii\base\BaseObject::init()
     * @throws \InvalidArgumentException
     */
    public function init()
    {
        parent::init();
        
        $this->initRates();
        
        $this->_list=[
            [
                "asset" => [$this->_rates['AETP'],$this->_rates['FETP']],
                "change" => [$this->_rates['AETP_PL_FETP']]
            ],
        ];
    }
    
    private function initRates()
    {
        $this->_rates=[];
        $this->_rates['AETP']=RatesManager::getBySlxId('Y6UJ9A0000XM');       
        $this->_rates['FETP']=RatesManager::getBySlxId('Y6UJ9A0000XL');
        $this->_rates['AETP_PL_FETP']=RatesManager::getBySlxId('Y6UJ9A0000XN');
        
        foreach ($this->_rates as $key => $rate){
            if(!Obj::isA($rate, Rate::class)){
                throw new \InvalidArgumentException("Array _rates['{$key}'] is not ".Rate::class." type");
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
        
        foreach ($this->_list as $item){
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