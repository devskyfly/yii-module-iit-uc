<?php
namespace devskyfly\yiiModuleIitUc\models\servicePackage;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\service\Service;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackage;

class ServicePackageToServiceBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Service::class;
    }

    protected static function masterCls()
    {
        return ServicePackage::class;
    }
}

