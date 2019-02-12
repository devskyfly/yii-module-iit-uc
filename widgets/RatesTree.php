<?php
namespace devskyfly\yiiModuleIitUc\widgets;

use yii\base\Widget;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\php56\types\Vrbl;

class RatesTree extends Widget
{
    public $model;
    protected $list=[];
    
    public function init()
    {
        if(!Vrbl::isNull($this->model)){
            RatesManager::checkModel($this->model);
        }
        $this->list=RatesManager::getAllChilds($this->model);
    }
    
    public function run()
    {
        $list=$this->list;
        return $this->render('rates-tree',compact("list"));
    }
}