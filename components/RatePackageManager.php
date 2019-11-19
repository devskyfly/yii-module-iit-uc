<?php
namespace devskyfly\yiiModuleIitUc\components;

use yii\base\BaseObject;
use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle;
use devskyfly\yiiModuleIitUc\models\ratePackage\RatePackage;
use devskyfly\yiiModuleIitUc\models\ratePackage\RatePackageToRateBinder;

class RatePackageManager extends BaseObject
{
    public static function getByRate($model)
    {
        $result=null;

        if (Obj::isA($model,RateBundle::class)) {
            return $result;
        }

        if(!Obj::isA($model,Rate::class) ){
            throw new \InvalidArgumentException('Parameter $model is not '.Rate::class.' type.');
        }
        
        $rates_packages = RatePackage::find()->where(['active'=>'Y'])->all(); 
        
        foreach ($rates_packages as $rate_package){
            $ratesIds=RatePackageToRateBinder::getSlaveIds($rate_package->id);
            
            foreach ($ratesIds as $rateId){
                if($model->id == $rateId){
                    return $rate_package;
                }
            }
        }
            
        return $result;
    }
    
    /**
     * 
     * @param RatePackage $package
     * @throws \InvalidArgumentException
     * @return \devskyfly\yiiModuleIitUc\models\rate\Rate[]
     */
    public static function getRates($package)
    {
        $rates=[];
        if(!Obj::isA($package, RatePackage::class)){
            throw new \InvalidArgumentException('Parameter $package is not '.RatePackage::class.' type.');
        }
        
        $rates=RatePackageToRateBinder::getSlaveItems($package->id);
        return $rates;
    }
}