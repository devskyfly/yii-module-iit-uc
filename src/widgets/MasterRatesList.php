<?php
namespace devskyfly\yiiModuleIitUc\widgets;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleIitUc\models\site\Site;
use yii\base\Widget;
use devskyfly\yiiModuleIitUc\components\SitesManager;

class MasterRatesList extends Widget
{
    public $model=null;
    protected $list=[];
    
    public function init()
    {
        parent::init();
        if(!Obj::isA($this->model,Site::class)){
            throw new \InvalidArgumentException('Property $model is not '.Site::class.' type.');
        }
        if(!$this->model->isNewRecord){
            $this->list=SitesManager::getRates($this->model);
        }
    }
    
    public function run()
    {
        $list=$this->list;
        return $this->render('master-rates-list',compact("list"));    
    }
}