<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\power\Power;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class PowersController extends CommonController
{
    public function actionIndex()
    {
        $data=[];
        $power_cls=Power::class;
        

        $items=$power_cls::find()
        ->where(['active'=>'Y'])
        ->orderBy(['sort'=>SORT_ASC])
        ->all();
        
        foreach ($items as $item){
            $data[]=[
                "id"=>$item->id,
                "name"=>$item->name,
                "oid"=>$item->oid
            ];
        }
        
        $this->asJson($data);
    }
}