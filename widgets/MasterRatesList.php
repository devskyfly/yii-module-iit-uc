<?php
namespace devskyfly\yiiModuleIitUc\widgets;

use yii\base\Widget;

class MasterRatesList extends Widget
{
    public function init()
    {
        parent::init();
    }
    
    public function run()
    {
        $list=[];
        return $this->render('master-rates-list',compact("list"));    
    }
}