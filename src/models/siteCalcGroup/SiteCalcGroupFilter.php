<?php
namespace devskyfly\yiiModuleIitUc\models\siteCalcGroup;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterTrait;

class SiteCalcGroupFilter extends SiteCalcGroup implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [
            [['active','name','create_date_time','change_date_time'],"string"]
        ];
    }
}