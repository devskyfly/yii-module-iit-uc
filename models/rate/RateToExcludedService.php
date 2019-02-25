<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\service\Service;

class RateToExcludedService extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Service::class;
    }
    
    protected static function masterCls()
    {
        return Rate::class;
    }
}