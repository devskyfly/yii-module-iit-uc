<?php
namespace devskyfly\yiiModuleIitUc\widgets;

use yii\base\Widget;

class SlaveSitesList extends Widget
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