<?php
namespace devskyfly\yiiModuleIitUc\models\stock;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\service\Service;


class StockToCheckedServiceBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Service::class;
    }
    
    protected static function masterCls()
    {
        return Stock::class;
    }
    
}

