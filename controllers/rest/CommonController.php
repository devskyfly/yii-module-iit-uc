<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use yii\web\Response;
use yii\web\Controller;

class CommonController extends Controller
{
    public $mode_list=[];
    
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