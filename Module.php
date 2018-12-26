<?php
namespace devskyfly\yiiModuleIitUc;

use Yii;

class Module extends \yii\base\Module
{
     const CSS_NAMESPACE='devskyfly-yii-iit-uc';
     
     public function init()
     {
         parent::init();
         //$this->checkProperties();
         if(Yii::$app instanceof \yii\console\Application){
             $this->controllerNamespace='devskyfly\yiiModuleIitUc\console';
         }
     }
     
     /* protected function checkProperties()
     {
         
     } */
}