<?php
namespace devskyfly\yiiModuleIitUc;

use Yii;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
     const CSS_NAMESPACE='devskyfly-yii-iit-uc';
     const TITLE="Модуль \"УЦ\"";
     
     public function init()
     {
         parent::init();
         Yii::setAlias("@devskyfly/yiiModuleIitUc", __DIR__);
         if(Yii::$app instanceof \yii\console\Application){
             $this->controllerNamespace='devskyfly\yiiModuleIitUc\console';
         }
     }
     
     public function behaviors()
     {
         if(!(Yii::$app instanceof \yii\console\Application)){
             if(!YII_DEBUG){
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
             }
             else{
               return [];
             }
         }else{
             return [];
         }
     }
}