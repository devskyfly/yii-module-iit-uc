<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
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
                "change"
            ],
        ];
    }
    
    private function initRates()
    {
        $this->_rates=[];
        $this->_rates['AETP']=RatesManager::getBySlxId('Y6UJ9A0000XM');
        $this->_rates['B2b']=RatesManager::getBySlxId('Y6UJ9A0000XP');
        $this->_rates['FETP']=RatesManager::getBySlxId('Y6UJ9A0000XL');
        
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
        
        foreach ($models as $model){
            if(Obj::isA($model, Rate::class)){
                throw \InvalidArgumentException('Item $models is not '.Rate::class.' type.');
            }
        }
        
        foreach ($this->_list as $item){
            if(in_array($item['master'], $models)){
                
                foreach ($models as $key => $rate){
                    if($rate==$item['master']){
                        unset($models[$key]);
                    }
                }
                
                $binds=ArrayHelper::merge($binds,$item['slave']);
            }
        }
        $binds=array_unique($binds);
        
        return $binds;
    }
}