<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

/**
 * Set Cors behavior
 */
abstract class CommonController extends Controller
{
    public $mode_list=[];
    
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
            ],
        ], parent::behaviors());
    }
    
    public function init()
    {
        parent::init();
        $this->mode_list=['Y','N'];   
    }
}