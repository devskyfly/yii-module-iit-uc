<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\Rate;

class SalesList extends BaseObject
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
                "rates" => [  $this->_rates['AETP'],  $this->_rates['B2b'] ],
                "sale" => 2000
            ],
            [
                "rates" => [  $this->_rates['AETP_PL_FETP'],  $this->_rates['B2b'] ],
                "sale" => 2000
            ]            
        ];
    }
    
    private function initRates()
    {
        $this->_rates=[];
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
     * @param Rate[] $asset
     * @throws \InvalidArgumentException
     * @return boolean
     */
    private function match($models,$asset)
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
        foreach ($this->_list as $item){
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