<?php
namespace devskyfly\yiiModuleIitUc\widgets;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleIitUc\components\PowersManager;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\base\Widget;


class SlavePowersList extends Widget
{
    public $model=null;
    
    protected $list=null;
    
    public function init()
    {
        parent::init();
        if(!Obj::isA($this->model,Rate::class)){
            throw new \InvalidArgumentException('Property $model is not '.Rate::class.' type.');
        }
        if(!$this->model->isNewRecord){
            $this->list=PowersManager::getGroupedList($this->model);
        }else{
            $this->list=[];
        }
    }
    
    public function run()
    {
        $list=$this->list;
        return $this->render('slave-powers-list',compact("list"));
    }
}