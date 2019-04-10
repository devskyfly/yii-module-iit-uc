<?php
namespace devskyfly\yiiModuleIitUc\models\ratePackage;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\rate\Rate;

class RatePackageToRateBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Rate::class;
    }
    
    protected static function masterCls()
    {
        return RatePackage::class;
    }
}

