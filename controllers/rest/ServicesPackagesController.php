<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use yii\web\BadRequestHttpException;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\models\service\Service;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackage;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\models\stock\StockToServicePackageBinder;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackageToServiceBinder;
use devskyfly\yiiModuleIitUc\components\ServicesManager;
use Yii;

class ServicesPackagesController extends CommonController
{
    public function actionIndex(array $ids, $mode_list='N')
    {
        try{
            if(!in_array($mode_list,$this->mode_list)){
                throw new BadRequestHttpException('Query param \'mode_list\' aout of range.');
            }
            
            $rates=[];
            foreach ($ids as $id){
                $rates[]=RatesManager::getBySlxId($id);
            }
            
            $rates_chain=RatesManager::getMultiChain($rates);
            $excluded_services=ServicesManager::getExcludedByRateChain($rates_chain);
            $excluded_services_ids=[];
            
            foreach ($excluded_services as $excluded_service){
                $excluded_services_ids[]=$excluded_service->id;
            }
            
            $data=[];
            $stock_cls=Stock::class;
            $service_package_cls=ServicePackage::class;
            $stock_to_service_package_binder=StockToServicePackageBinder::class;
            $service_package_to_service=ServicePackageToServiceBinder::class;
           
            
            $service_packages=ServicePackage::find()
            ->where(['active'=>'Y'])
            ->orderBy(['sort'=>SORT_ASC])->all();
            
            foreach ($service_packages as $service_package){
                if($service_package->active=='N')continue;
                $list=[];
                
                $service_ids=$service_package_to_service::getSlaveIds($service_package->id);
                $services=Service::find()
                ->where(['active'=>'Y','id'=>$service_ids])
                ->orderBy(['name'=>SORT_ASC])->all();
                
                if($mode_list=='Y'){
                    foreach ($services as $service){
                        if(in_array($service->id, $excluded_services_ids))continue;
                        $list[]=[
                            'id'=>$service->id,
                            'name'=>$service->name,
                            'price'=>$service->price,
                        ];
                    }
                }else{
                    foreach ($services as $service){
                        if(in_array($service->id, $excluded_services_ids))continue;
                        $list[]=$service->slx_id;
                    }
                }
                
                $package_data=[
                    'id'=>$service_package->id,
                    'name'=>$service_package->name,
                    'select_type'=>$service_package->select_type,
                    'list'=>$list
                ];
                
                $data[]=$package_data;
            }
            
            $this->asJson($data);
        }catch(\Exception $e)
        {
            Yii::error($e,self::class);
            throw new NotFoundHttpException();
        }
    }
    
    private function actionGetByStockId($id, $mode_list='N')
    {
        if(!in_array($mode_list,$this->mode_list)){
            throw new BadRequestHttpException('Query param \'mode_list\' aout of range.');
        }
        
        $data=[];
        $stock_cls=Stock::class;
        $service_package_cls=ServicePackage::class;
        $stock_to_service_package_binder=StockToServicePackageBinder::class;
        $service_package_to_service=ServicePackageToServiceBinder::class;
        
        try {
            $id=Nmbr::toIntegerStrict($id);
        }catch (\Throwable $e){
            throw new BadRequestHttpException('Query param \'id\' is not integer type.');
        }catch (\Exception $e){
            throw new BadRequestHttpException('Query param \'id\' is not integer type.');
        }
        
        $stock=$stock_cls::find()->where(['active'=>'Y'])->one();
        
        if(Vrbl::isNull($stock)){
            throw new NotFoundHttpException("Stock with id={$id} is not found.");
        }
        
        $binder=new $stock_to_service_package_binder();
        $service_package_ids=$stock_to_service_package_binder::getSlaveIds($stock->id);
        
        $service_packages=ServicePackage::find()
        ->where(['active'=>'Y','id'=>$service_package_ids])
        ->orderBy(['sort'=>SORT_ASC])->all();
        
        foreach ($service_packages as $service_package){
            if($service_package->active=='N')continue; 
            $list=[];
            
            $service_ids=$service_package_to_service::getSlaveIds($service_package->id);
            $services=Service::find()
            ->where(['active'=>'Y','id'=>$service_ids])
            ->orderBy(['sort'=>SORT_ASC])->all();
            
            if($mode_list=='Y'){
                foreach ($services as $service){
                    $list[]=[
                        'id'=>$service->id,
                        'name'=>$service->name,
                        'price'=>$service->price,
                    ];
                }
            }else{
                foreach ($services as $service){
                    $list[]=[
                        $service->id
                    ];
                }
            }
            
            $package_data=[
                'id'=>$service_package->id,
                'name'=>$service_package->name,
                'type'=>$service_package->select_type=='MULTI'?'checkbox':'radio',
                'list'=>$list
            ];
            
            $data[]=$package_data;
        }
        
        $this->send($data);
    }
}