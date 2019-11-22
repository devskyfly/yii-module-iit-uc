<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Vrbl;
use yii\base\BaseObject;

abstract class AbstractRatesAsset extends BaseObject
{
    protected $list=[];
    
    public $idsList=[];
    
    protected $rates_keys=[
        //For promo
        'asset',
        'change',
        //For sales
        'rates',
        //For binding
        'master',
        'slave'];
    
    public function init()
    {
        parent::init();
        if(Vrbl::isEmpty($this->idsList)){
            $this->idsList=$this->initIdsList();
        }
        $this->generate();
    }
    
    /**
     * Return array on rates relations
     * 
     * @return []
     */
    abstract public function initIdsList();
    
    /**
     * Initialize $this->list using $this->idsList
     * 
     * It copies array struct from idsList but change ids on rates.
     *
     * @return void
     */
    protected function generate()
    {
        foreach ($this->idsList as $listItem){
            $ratesListItem=[];
            foreach ($listItem as $key=>$item){
                if(in_array($key, $this->rates_keys)){
                    if(is_array($item)){
                        $ratesList=[];
                        foreach ($item as $subItem){
                            $rate=RatesManager::getBySlxId($subItem);
                            if(Vrbl::isNull($rate)){
                                throw new \InvalidArgumentException("There is no rate with '{$subItem}'.");
                            }
                            $ratesList[]=$rate;
                        }
                        $ratesListItem[$key]=$ratesList;
                    }else{
                        $rate=RatesManager::getBySlxId($item);
                        if(Vrbl::isNull($rate)){
                            throw new \InvalidArgumentException("There is no rate with '{$subItem}'.");
                        }
                        $ratesListItem[$key]=$rate;
                    }
                }else{
                    $ratesListItem[$key]=$item;
                }
            }
            $this->list[]=$ratesListItem;
        }
    }
}