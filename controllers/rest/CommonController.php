<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;

abstract class CommonController extends Controller
{
    public $mode_list=[];
    
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                /* 'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['*'],
                ], */
            ],
        ], parent::behaviors());
    }
    
    public function init()
    {
        parent::init();
        $this->mode_list=['Y','N'];   
    }
    
    public function send($data)
    {
        if(!YII_DEBUG){
            return "<pre>".print_r($data)."</pre>";
        }else{
            $this->asJson($data);
        }
    }
}