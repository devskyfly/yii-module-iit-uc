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
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\RatePackageManager;
use Yii;
use yii\web\ServerErrorHttpException;

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
        try{
            $result=[];
            $models=[];
            $ratesPackages=[];
            
            foreach ($ids as $id){
                $models[]=RatesManager::getBySlxId($id);
            }
            
            $modelCnt=Arr::getSize($models);
            for($mdlItr=0;$mdlItr<$modelCnt;$mdlItr++){
                $ratePackage=RatePackageManager::getByRate($models[$mdlItr]);
                if(!Vrbl::isNull($ratePackage)){
                    unset($models[$mdlItr]);
                    $parentRate=Rate::getById($ratePackage->_parent_rate__id);
                    if(Vrbl::isNull($parentRate)){
                        throw new \RuntimeException('Parameter $parentRate is null.');
                    }
                    $models[]=$parentRate;
                    $ratesPackages[]=$ratePackage;
                }
            }
            
            array_unique($models);
            
            $promoList = new PromoList();
            $bindsList = new BindsList();
    
            $chain=RatesManager::getMultiChain($models, $promoList, $bindsList);
            
            foreach ($chain as $item){
                
                $powersPackages=RateToPowerPackageBinder::getSlaveItems($item->id);
                $powers_packages_ids=[];
                $rates_packages_ids=[];
                
                foreach ($powersPackages as $powerPackage){
                    if($powerPackage->active==PowerPackage::ACTIVE){
                        $powers_packages_ids[]=$package->id;
                    }
                }
                
                foreach ($ratesPackages as $ratePackage){
                    if($ratePackage['_parent_rate__id']==$item->id){
                        $packageRates=RatePackageManager::getRates($ratePackage);
                        foreach ($packageRates as $packageRate){
                            $rates_packages_ids[]=$packageRate->id;
                        }
                    }
                }
                
                $rates_packages_ids=array_unique($rates_packages_ids);
                
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
                    "powers_packages"=>$powers_packages_ids,
                    "rates_packages"=>$rates_packages_ids,
                    "required_powers"=>[],
                    "stock_id"=>Vrbl::isNull($stock)?'':$stock->stock,
                    "required_license"=>$item->flag_for_license=='Y'?true:false
                ];
            }    
            $this->asJson($result);
        }catch(\Exception $e)
        {
            Yii::error($e,self::class);
            throw new NotFoundHttpException();
        }
    }   
}