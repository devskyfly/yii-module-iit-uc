<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class RatesController extends CommonController
{
    public function actionGetBySlxIds(array $ids)
    {
        $data=[];
        $rates_cls=Rate::class;
        
        if(!Arr::isArray($ids)){
            throw new BadRequestHttpException('Query param \'ids\' is not array type.');
        }
        
        foreach ($ids as $id){
            if(!Str::isString($id)){
                throw new BadRequestHttpException('Query param \'id\' is not string type.');
            }
            $item=$rates_cls::find()
            ->where(
                ['active'=>'Y',
                'slx_id'=>$id])
            ->one();
            
            if(Vrbl::isNull($item)){
                throw new NotFoundHttpException("Rate with slx_id='{$id}' is not found.");
            }
            
            $data[]=[
                "id"=>$item->id,
                "name"=>$item->name,
                "price"=>$item->price
            ];
        }
        
        $this->asJson($data);
    }
}