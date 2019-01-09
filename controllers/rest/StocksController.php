<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Vrbl;

use devskyfly\yiiModuleIitUc\models\stock\Stock;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use devskyfly\php56\types\Nmbr;

class StocksController extends CommonController
{
    public function actionGetById($id)
    {
        $data=[];
        $stocs_cls=Stock::class;
        
        try {
            $id=Nmbr::toIntegerStrict($id);
        }catch (\Throwable $e){
            throw new BadRequestHttpException('Query param \'id\' is not integer type.');
        }catch (\Exception $e){
            throw new BadRequestHttpException('Query param \'id\' is not integer type.');
        }
        
        $item=$stocs_cls::find()
        ->where(['id'=>$id,'active'=>'Y'])
        ->one();
        
        if(Vrbl::isNull($item)){
            throw new NotFoundHttpException("Stock with id='{$id}' is not found.");
        }
            
        $data[]=[
            "name"=>$item->name,
            "stock"=>$item->stock
        ];

        $this->asJson($data);
    }
}