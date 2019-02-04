<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Str;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\models\powerPackage\PowerPackage;
use devskyfly\php56\types\Nmbr;

class RatesController extends CommonController
{
    private function actionGetBySlxIds(array $ids)
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
    
    private function actionGetChain($id){
        
        $model=RatesManager::getBySlxId($id);
        $chain=RatesManager::getChain($model);
        $this->asJson($chain);
    }
    
    public function actionIndex(array $ids){
        $result=[];
        
        $models=[];
        foreach ($ids as $id){
            $models[]=RatesManager::getBySlxId($id);
        }
        
        $chain=RatesManager::getMultiChain($models);
        
        foreach ($chain as $item){
            
            $packages=RateToPowerPackageBinder::getSlaveItems($item->id);
            $packages_ids=[];
            foreach ($packages as $package){
                if($package->active==PowerPackage::ACTIVE){
                    $packages_ids[]=$package->id;
                }
            }
            
            $stock=null;
            if(!Vrbl::isEmpty($item->_stock__id)){
                $stock=Stock::find()
                ->where([
                    'active'=>Stock::ACTIVE,
                    'id'=>$item->_stock__id  
                ])
                ->one();
                
                if(Vrbl::isEmpty($stock)){
                    throw new \RuntimeException('Parameter $stock is empty.');
                }
            }
            
            $result[]=[
                "id"=>$item->id,
                "name"=>$item->name,
                "slx_id"=>$item->slx_id,
                "price"=>Nmbr::toDoubleStrict($item->price),
                "powers_packages"=>$packages_ids,
                "required_powers"=>[],
                "stock_id"=>Vrbl::isNull($stock)?'':$stock->stock,
                "required_license"=>$item->flag_for_license=='Y'?true:false
            ];
        }    
        $this->asJson($result);  
    }   
}