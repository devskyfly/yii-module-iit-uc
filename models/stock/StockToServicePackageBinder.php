<?php
namespace devskyfly\yiiModuleIitUc\models\stock;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackage;


class StockToServicePackageBinder extends AbstractBinder
{
    protected function slaveCls()
    {
        return ServicePackage::class;
    }
    
    protected static function masterCls()
    {
        return Stock::class;
    }
    
}

