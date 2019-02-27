<?php
namespace devskyfly\yiiModuleIitUc\models\site;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterTrait;

class SiteFilter extends Site implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [
            [['active','name','create_date_time','change_date_time'],"string"]
        ];
    }
}