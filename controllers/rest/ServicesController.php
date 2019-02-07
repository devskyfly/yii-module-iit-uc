<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\service\Service;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ServicesController extends CommonController
{
    public function actionIndex()
    {
        $data=[];
        $service_cls=Service::class;
        
        $items=$service_cls::find()
        ->where(['active'=>'Y'])
        ->all();
        
        foreach ($items as $item){
            if(empty($item->slx_id)){continue;}
            $data[]=[
                "name"=>$item->name,
                "price"=>Nmbr::toDoubleStrict($item->price),
                "slx_id"=>$item->slx_id
            ];
        }
        
        $this->asJson($data);
    }
}