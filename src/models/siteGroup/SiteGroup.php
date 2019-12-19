<?php
namespace devskyfly\yiiModuleIitUc\models\siteGroup;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use devskyfly\yiiModuleIitUc\traits\DbTrait;

class SiteGroup extends AbstractEntity
{
    use DbTrait;
    
    public static function sectionCls()
    {
    	 
        return null;
    }
    
    public function extensions()
    {
        return [
            
        ];
    }
    
    public static function selectListRoute()
    {
        return "/iit-uc/sitesGroup/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_site_group';
    }

    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::binders()
     */
    public function binders(){
        return [
            'SiteGroupToSiteBinder'=>SiteGroupToSiteBinder::class            
        ];
    }
}