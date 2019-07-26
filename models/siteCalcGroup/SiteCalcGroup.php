<?php
namespace devskyfly\yiiModuleIitUc\models\siteCalcGroup;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;

class SiteCalcGroup extends AbstractEntity
{
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
        return "/iit-uc/sitesCalcGroup/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_site_calc_group';
    }

    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::binders()
     */
    public function binders(){
        return [
            'SiteCalcGroupToSiteBinder'=>SiteCalcGroupToSiteBinder::class            
        ];
    }
}