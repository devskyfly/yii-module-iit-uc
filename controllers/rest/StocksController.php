<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Vrbl;

use devskyfly\yiiModuleIitUc\models\service\Service;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackage;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\stock\StockToServicePackageBinder;

class StocksController extends CommonController
{
    public function actionIndex()
    {
        $data=[];
        $stocs_cls=Stock::class;
        $packages_cls=ServicePackage::class;
        $service_cls=Service::class;
        $stock_to_service_package_binder_cls=StockToServicePackageBinder::class;
        
        $stocks=$stocs_cls::find()
        ->where(['active'=>'Y'])
        ->all();
        
        foreach ($stocks as $stock){
            $services_pakages_ids=[];
            $checked_services_ids=[];
            
            //Services
            $services_pakages_ids=$stock_to_service_package_binder_cls::getSlaveIds($stock->id);
            
            $packages=$packages_cls::find()
            ->where(['id'=>$services_pakages_ids,'active'=>'Y'])
            ->all();
            
            $ids=[];
            foreach ($packages as $package){
                $ids[]=$package->id;
            }

            $services_pakages_ids=$ids;
            
            //Checked services
            $checked_services_ids=$stock_to_service_package_binder_cls::getSlaveIds($stock->id);
            
            $services=$service_cls::find()
            ->where(['id'=>$checked_services_ids,'active'=>'Y'])
            ->all();
            
            $ids=[];
            foreach ($services as $service){
                $ids[]=$service->id;
            }
            
            $checked_services_ids=$ids;
            
            //data
            $data[]=[
                "name"=>$stock->name,
                "stock"=>$stock->stock,
                "additional_services_pakages"=>$services_pakages_ids,
                "checked_additional_services"=>$checked_services_ids,
                "client_types"=>Json::decode($stock->client_type)
            ];
        }
        
        $this->asJson($data);
    }
    
    private function actionGetById($id)
    {
        $data=[];
        $stocs_cls=Stock::class;
        $packages_cls=ServicePackage::class;
        $stock_to_service_package_binder_cls=StockToServicePackageBinder::class;
        
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
        
        $services_pakages_ids=[];
        
        $services_pakages_ids=$stock_to_service_package_binder_cls::getSlaveIds($item->id);
        $packages=$packages_cls::find()->where(['id'=>$services_pakages_ids])->all();
        $ids=[];
        foreach ($packages as $package){
            $ids[]=$package->id;
        }
        $services_pakages_ids=$ids;
        $data[]=[
            "name"=>$item->name,
            "stock"=>$item->stock,
            "additional_services_pakages"=>$services_pakages_ids,
            "client_types"=>$item->client_type
        ];

        $this->asJson($data);
    }
}