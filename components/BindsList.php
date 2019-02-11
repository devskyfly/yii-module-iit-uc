<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Obj;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\helpers\ArrayHelper;

class BindsList extends BaseObject
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
                "master" => $this->_rates['AETP'], 
                "slave"=>[
                    $this->_rates['B2b']
                ],
            ],
            [
                "master" => $this->_rates['FETP'],
                "slave"=>[
                    $this->_rates['AST_GOZ']
                ],
            ],
            [
                "master" => $this->_rates['AETP_PL_FETP'],
                "slave"=>[
                    $this->_rates['B2b']
                ],
            ],
        ];
    }
    
    private function initRates()
    {
        $this->_rates=[];
        $this->_rates['AST_GOZ']=RatesManager::getBySlxId('Y6UJ9A0002H1');
        $this->_rates['AETP']=RatesManager::getBySlxId('Y6UJ9A0000XM');
        $this->_rates['B2b']=RatesManager::getBySlxId('Y6UJ9A0000XP');
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
        
        foreach ($this->_list as $item){
            if(in_array($item['master'], $models)){
                $binds=ArrayHelper::merge($binds,$item['slave']);
            }
        }
        $binds=array_unique($binds); 
        
        return $binds;
    }
}