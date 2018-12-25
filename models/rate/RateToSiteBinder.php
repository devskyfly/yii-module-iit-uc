<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\site\Site;

class RateToSiteBinder extends AbstractBinder
{
    protected function slaveCls()
    {
        return Site::class;
    }

    protected static function masterCls()
    {
        return Rate::class;
    }

}

