<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\powerPackage\PowerPackage;


class RateToPowerPackageBinder extends AbstractBinder
{
    protected function slaveCls()
    {
        return PowerPackage::class;
    }

    protected static function masterCls()
    {
        return Rate::class;
    }
}

