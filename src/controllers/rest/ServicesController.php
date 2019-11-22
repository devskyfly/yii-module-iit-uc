<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\service\Service;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Rest api class
 */
class ServicesController extends CommonController
{

    /**
     * Return services
     * GET
     * 
     * [
     *  [
     *      name: string,
     *      price: number,
     *      slx_id: string,
     *      comment: string,
     *      fast_release: boolean,
     *      required_license: boolean,
     *  ],...
     * ]
     */
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
                    "comment"=>$item->comment,
                    "fast_release" => $item->flag_is_fast_release=="Y"?true:false,
                    "required_license" => $item->flag_for_license=="Y"?true:false
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