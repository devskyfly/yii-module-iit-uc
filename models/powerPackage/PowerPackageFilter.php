<?php
namespace devskyfly\yiiModuleIitUc\models\powerPackage;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterTrait;

class PowerPackageFilter extends PowerPackage implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [
            [['active','name','create_date_time','change_date_time'],"string"]
        ];
    }
}