<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use yii\web\BadRequestHttpException;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\ratePackage\RatePackage;
use devskyfly\yiiModuleIitUc\models\ratePackage\RatePackageToRateBinder;


/**
 * Rest api class
 */
class RatesPackagesController extends CommonController
{
    /**
     * Return rates packages
     * GET
     *
     * Return:
     * [
     *  [
     *      'id': number,
     *      'name': string,
     *      'select_type': string['MULTI', 'MONO'],
     *      'list': number[]
     *  ],...
     * ]
     */
    public function actionIndex($mode_list='N')
    {
        if(!in_array($mode_list,$this->mode_list)){
            throw new BadRequestHttpException('Param $mode_list is out of range.');
        }
        $data=[];
        $packages=RatePackage::find()
        ->where(['active'=>'Y'])
        ->orderBy(['sort'=>SORT_ASC])
        ->all();
        
        
        foreach ($packages as $package){
            $package_data=[];
            $list=[];
            
            $ids=RatePackageToRateBinder::getSlaveIds($package->id);
            $rates=Rate::find()
            ->where(['active'=>'Y','id'=>$ids])
            ->orderBy(['name'=>SORT_ASC])
            ->all();
            
            if($mode_list=='Y'){
                foreach ($rates as $rate){
                    $list[]=[
                        'id'=>$rate->id,
                        'name'=>$rate->name,
                        'slx_id'=>$rate->slx_id
                    ];
                }
            }else{
                foreach ($rates as $rate){
                    $list[]=$rate->slx_id;
                }
            }
            
            $package_data=[
                'id'=>$package->id,
                'name'=>$package->name,
                'select_type'=>$package->select_type=='MULTI'?'MULTI':'MONO',
                'list'=>$list
            ];
            
            $data[]=$package_data;
        }
        
        
        $this->asJson($data);
    }
    
    /* private function actionGetByRateId($id,$mode_list='N')
    {
        if(!in_array($mode_list,$this->mode_list)){
            throw new BadRequestHttpException('Param $mode_list is out of range.');
        }
        
        $data=[];

        $rate_cls=Rate::class;
        $rate_to_power_package=RateToPowerPackageBinder::class;
        $power_package_cls=PowerPackage::class;
        $power_cls=Power::class;
        $power_packages_to_power_binder=PowerPackageToPowerBinder::class;
        
        try {
            $id=Nmbr::toIntegerStrict($id);
        }catch (\Throwable $e){
            throw new BadRequestHttpException('Param $id is not integer type.');
        }catch (\Exception $e){
            throw new BadRequestHttpException('Param $id is not integer type.');
        }
        
        $rate=$rate_cls::find()
        ->where(['active'=>'Y','id'=>$id])
        ->one();
        
        if(Vrbl::isNull($rate)){
            throw new NotFoundHttpException("Item with id='{$id}' is not found.");
        }
        
        $power_pakages_ids=$rate_to_power_package::getSlaveIds($rate->id);
        
        $powers_packages=$power_package_cls::find()
        ->where(['active'=>'Y','id'=>$power_pakages_ids])
        ->orderBy(['sort'=>SORT_ASC])
        ->all();
        
      
        foreach ($powers_packages as $power_package){
            $package_data=[];
            $list=[];
            
            $power_ids=$power_packages_to_power_binder::getSlaveIds($power_package->id);
            $powers=$power_cls::find()
            ->where(['active'=>'Y','id'=>$power_ids])
            ->orderBy(['sort'=>SORT_ASC])
            ->all();
            
            if($mode_list=='Y'){
                foreach ($powers as $power){
                    $list[]=[
                        'id'=>$power->id,
                        'name'=>$power->name,
                        'slx_id'=>$power->slx_id
                    ];
                }
            }else{
                foreach ($powers as $power){
                    $list[]=$power->id;
                }
            }
            
            $package_data=[
                'id'=>$power_package->id,
                'name'=>$power_package->name,
                'type'=>$power_package->select_type=='MULTI'?'checkbox':'radio',
                'list'=>$list
            ];
           
            $data[]=$package_data;
        }
        

        $this->asJson($data);
    } */
}