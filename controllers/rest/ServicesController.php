<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\service\Service;
use Yii;
use yii\web\NotFoundHttpException;

class ServicesController extends CommonController
{
    public function actionIndex()
    {
        try{
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
                    "slx_id"=>$item->slx_id,
                    "comment"=>$item->comment
                ];
            }
            
            $this->asJson($data);
        }catch(\Exception $e)
        {
            Yii::error($e,self::class);
            throw new NotFoundHttpException();
        }
    }
}