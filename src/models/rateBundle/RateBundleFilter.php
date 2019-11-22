<?php
namespace devskyfly\yiiModuleIitUc\models\rateBundle;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterInterface;
use devskyfly\yiiModuleAdminPanel\models\contentPanel\FilterTrait;

class RateBundleFilter extends RateBundle implements FilterInterface
{
    use FilterTrait;
    
    public function rules()
    {
        return [
            [['active','name','create_date_time','change_date_time'],"string"]
        ];
    }
}