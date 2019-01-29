<?php
namespace devskyfly\yiiModuleIitUc\widgets;

use yii\base\Widget;
use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleIitUc\components\SitesManager;
use devskyfly\yiiModuleIitUc\models\rate\Rate;

class SlaveSitesList extends Widget
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
            $this->list=SitesManager::getChainSites($this->model);}
        else{
            $this->list=[];
        }
    }
    
    public function run()
    {
        $list=$this->list;
        return $this->render('slave-sites-list',compact("list")); 
    }
}