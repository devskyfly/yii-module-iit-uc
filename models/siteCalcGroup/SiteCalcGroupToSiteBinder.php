<?php
namespace devskyfly\yiiModuleIitUc\models\siteCalcGroup;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\site\Site;

class SiteCalcGroupToSiteBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Site::class;
    }

    protected static function masterCls()
    {
        return SiteCalcGroup::class;
    }
}

