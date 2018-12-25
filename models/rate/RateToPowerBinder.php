<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\power\Power;

class RateToSiteBinder extends AbstractBinder
{
    protected function slaveCls()
    {
        return Power::class;
    }

    protected static function masterCls()
    {
        return Rate::class;
    }
}

