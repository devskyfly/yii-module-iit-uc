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

    public function initIdsList()
    {
        return Yii::$app->params['iit-uc']['binds-list']['idsList'];
    }
    
    
    
    public function initRates()
    {
        $this->rates=[];
        $this->rates['AST_GOZ']=RatesManager::getBySlxId('Y6UJ9A0002H1');
        $this->rates['AETP']=RatesManager::getBySlxId('Y6UJ9A0000XM');
        $this->rates['B2b']=RatesManager::getBySlxId('Y6UJ9A0000XP');
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