<?php
namespace devskyfly\yiiModuleIitUc;

use devskyfly\php56\types\Arr;
use Yii;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
     const CSS_NAMESPACE='devskyfly-yii-iit-uc';
     const TITLE="Модуль \"УЦ\"";
     
     public $db;

     public function init()
     {
         parent::init();
         Yii::setAlias("@devskyfly/yiiModuleIitUc", __DIR__);
         if(Yii::$app instanceof \yii\console\Application){
             $this->controllerNamespace='devskyfly\yiiModuleIitUc\console';
         }

         if(Arr::isArray($this->db)){
             $this->db = Yii::createObject($this->db);
         }
     }
     
     public function behaviors()
     {
         if(!(Yii::$app instanceof \yii\console\Application)){
                 return [
                     'access' => [
                         'class' => AccessControl::className(),
                         'except'=>[
                             'rest/*/*',
                         ],
                         'rules' => [
                              [
                                 'allow' => true,
                                 'roles' => ['@'],
                             ], 
                         ],
                     ]
                 ];
         }else{
             return [];
         }
     }
}