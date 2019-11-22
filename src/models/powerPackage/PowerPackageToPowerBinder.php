<?php
namespace devskyfly\yiiModuleIitUc\models\powerPackage;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\power\Power;

class PowerPackageToPowerBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Power::class;
    }

    protected static function masterCls()
    {
        return PowerPackage::class;
    }
}

