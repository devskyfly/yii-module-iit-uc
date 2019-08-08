<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\yiiModuleIitUc\models\service\Service;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackage;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\models\stock\StockToServicePackageBinder;
use devskyfly\yiiModuleIitUc\models\stock\StockToCheckedServiceBinder;


/**
 * Rest api class
 */
class StocksController extends CommonController
{
    /**
     * GET
     * 
     * Return json:
     * [
     *  [
     *      name:string,
     *      stock_id:number,
     *      additional_services_packages:number[],
     *      checked_additional_services:number[],
     *      client_types:["UL","IP","FIZ"]
     *  ],...
     * ]
     */
    public function actionIndex()
    {
        try{
            $data=[];
            $stocs_cls=Stock::class;
            $packages_cls=ServicePackage::class;
            $service_cls=Service::class;
            $stock_to_service_package_binder_cls=StockToServicePackageBinder::class;
            $stock_to_checked_service_binder_cls=StockToCheckedServiceBinder::class;
            $stocks=$stocs_cls::find()
            ->where(['active'=>'Y'])
            ->all();
            
            foreach ($stocks as $stock){
                $services_packages_ids=[];
                $checked_services_ids=[];
                
                //Services
                $services_packages_ids=$stock_to_service_package_binder_cls::getSlaveIds($stock->id);
                
                $packages=$packages_cls::find()
                ->where(['id'=>$services_packages_ids,'active'=>'Y'])
                ->all();
                
                $ids=[];
                foreach ($packages as $package){
                    $ids[]=$package->id;
                }
    
                $services_packages_ids=$ids;
                
                //Checked services
                $checked_services_ids=$stock_to_checked_service_binder_cls::getSlaveIds($stock->id);
                
                $services=$service_cls::find()
                ->where(['id'=>$checked_services_ids,'active'=>'Y'])
                ->all();
                
                $ids=[];
                foreach ($services as $service){
                    $ids[]=$service->id;
                }
                
                //$checked_services_ids=$ids;
                
                //data
                $data[]=[
                    "name"=>$stock->name,
                    "stock_id"=>$stock->stock,
                    "additional_services_packages"=>$services_packages_ids,
                    "checked_additional_services"=>$checked_services_ids,
                    "client_types"=>Json::decode($stock->client_type)
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