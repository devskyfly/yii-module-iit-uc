<?php
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\php56\types\Arr;

class ExcludedRatesFromBundleList extends AbstractRatesAsset
{
    public $idsList=[];

    public function init()
    {
        parent::init();
        if (Vrbl::isEmpty($this->idsList)) {
            $this->idsList=$this->initIdsList();
        }
    }

   public function initIdsList()
   {
        return Yii::$app->params['iit-uc']['excluded_rates_from_bundle_extending']['idsList'];
   }


   public function apply($models) {
       $models = array_values($models);
       $size = Arr::getSize($models);
       
       for ($i; $i<$size; $i++) {
            if (in_array($models[$i]->slx_id, $this->idsList)) {
                unset($models[$i]);
            }
       }
       
       $models = array_values($models);
       return $models;
   }

   protected function generate()
   {

   }
}