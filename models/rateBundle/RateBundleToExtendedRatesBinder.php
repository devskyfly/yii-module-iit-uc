<?php
namespace devskyfly\yiiModuleIitUc\models\rateBundle;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\rate\Rate;

class RateBundleToExtendedRatesBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Rate::class;
    }

    protected static function masterCls()
    {
        return RateBundle::class;
    }
}

