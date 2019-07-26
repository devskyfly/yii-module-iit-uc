<?php
namespace devskyfly\yiiModuleIitUc\models\rateCalcGroup;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\rate\Rate;

class RateCalcGroupToRateBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Rate::class;
    }

    protected static function masterCls()
    {
        return RateCalcGroup::class;
    }
}

