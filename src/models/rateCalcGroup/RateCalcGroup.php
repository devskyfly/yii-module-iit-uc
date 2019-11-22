<?php
namespace devskyfly\yiiModuleIitUc\models\rateCalcGroup;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use devskyfly\yiiModuleIitUc\traits\DbTrait;

class RateCalcGroup extends AbstractEntity
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
        return "/iit-uc/ratesCalcGroup/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_rate_calc_group';
    }

    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::binders()
     */
    public function binders(){
        return [
            'RateCalcGroupToRateBinder'=>RateCalcGroupToRateBinder::class            
        ];
    }
}