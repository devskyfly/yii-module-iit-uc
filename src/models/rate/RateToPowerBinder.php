<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\power\Power;

class RateToPowerBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Power::class;
    }

    protected static function masterCls()
    {
        return Rate::class;
    }
}

