<?php
namespace devskyfly\yiiModuleIitUc\models\siteGroup;

use devskyfly\yiiModuleIitUc\models\common\AbstractBinder;
use devskyfly\yiiModuleIitUc\models\site\Site;

class SiteGroupToSiteBinder extends AbstractBinder
{
    protected static function slaveCls()
    {
        return Site::class;
    }

    protected static function masterCls()
    {
        return SiteGroup::class;
    }
}

