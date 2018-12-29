<?php
namespace devskyfly\yiiModuleIitUc\console\service;

use yii\console\Controller;
use yii\helpers\Json;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\site\Site;
use devskyfly\yiiModuleIitUc\models\site\SiteSection;
use yii\helpers\BaseConsole;

use devskyfly\yiiModuleIitUc\models\rate\RateSection;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerBinder;
use devskyfly\yiiModuleIitUc\models\rate\RateToSiteBinder;
use devskyfly\yiiModuleIitUc\models\service\Service;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use Yii;
use yii\db\Exception;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackage;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackageToServiceBinder;
use devskyfly\yiiModuleIitUc\models\stock\StockToServicePackageBinder;
use devskyfly\yiiModuleIitUc\models\stock\StockToCheckedServiceBinder;

/**
 * This controller is only for initialithation of module.
 * 
 * @author devskyfly
 *
 */
class ImportController extends Controller
{
    public $data_path="";
    
    public function init()
    {
        $this->data_path=__DIR__."/../../data";
    }
    
    public function actionIndex()
    {
        $db=Yii::$app->db;
        $trns=$db->beginTransaction();
        
        try{
            $this->importRates();
            $this->importSites();
            $this->importServices();
            $this->importServicesPackages();
            $this->importStocks();
            
            //$this->import();
            $this->importRateToSiteBinder();     
        }
        catch (\Throwable $e){
            $trns->rollBack();
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
            return -1;
        }
        catch (\Exception $e){
            $trns->rollBack();
            BaseConsole::stdout($e->getMessage().PHP_EOL.$e->getTraceAsString().PHP_EOL);
             return -1;
        }
        $trns->commit();
        return 0;
    }
    
    public function importServicesPackages()
    {
        $packages=[
            ['name'=>'Базовый сертификат','ids'=>[1]],
            ['name'=>'ОФД','ids'=>[1,4]],
            ['name'=>'СМЭВ','ids'=>[1,4]],
            ['name'=>'ЕГАИС','ids'=>[2,12,4]],
            ['name'=>'Маркировка','ids'=>[2,12,4]],
            ['name'=>'Квал. для физ. лиц','ids'=>[1,4]],
            ['name'=>'Настройка рабочего места','ids'=>[5,4],'select_type'=>'MONO'],
        ];
        
        foreach ($packages as $package){
            $obj=new ServicePackage();
            $obj->active="Y";
            $obj->name=$package['name'];
            
            if(isset($package['select_type'])){
                $obj->select_type="MONO";
            }else{
                $obj->select_type="MULTI";
            }
            
            if(!$obj->saveLikeItem()){
                throw new Exception('Can\'t save service package: '.print_r($obj->getErrorSummary(true),true));
            }
            
            foreach ($package['ids'] as $id){
                $bind=new ServicePackageToServiceBinder();
                $bind->master_id=$obj->id;
                $bind->slave_id=$id;
                if(!$bind->insert()){
                    throw new Exception('Can\'t save service bind: '.print_r($bind->getErrorSummary(true),true));
                }
            }
        }
    }
    
    public function importStocks()
    {
        $stocks=[
            ['name'=>'Базовый сертификат','stock'=>'15',"client_type"=>"['UR','IP','FIZ']",'rate'=>2,'packages'=>[1,7],'services'=>[1]],
            ['name'=>'ОФД','stock'=>'42',"client_type"=>"['UR','IP']",'rate'=>18,'packages'=>[2],'services'=>[1]],
            //['name'=>'ОФД-Я','stock'=>'37','rate'=>],
            ['name'=>'СМЭВ','stock'=>'22',"client_type"=>"['UR']",'rate'=>[20,28],'packages'=>[3],'services'=>[1]],
            ['name'=>'ЕГАИС','stock'=>'25',"client_type"=>"['UR','IP']",'rate'=>3,'packages'=>[4],'services'=>[]],
            ['name'=>'Маркировка','stock'=>'92',"client_type"=>"['UR','IP']",'rate'=>27,'packages'=>[5],'services'=>[]],
            ['name'=>'Квал. для физ. лиц','stock'=>'39',"client_type"=>"['FIZ']",'rate'=>1,'packages'=>[6],'services'=>[1]],
        ];
        
        foreach ($stocks as $stock){
            $model=new Stock();
            $model->active='Y';
            $model->name=$stock['name'];
            $model->stock=$stock['stock'];
            $model->client_type=$stock['client_type'];
            
            if($model->saveLikeItem()){
                
                foreach ($stock['packages'] as $package_id){
                    $binder=new StockToServicePackageBinder();
                    $binder->master_id=$model->id;
                    $binder->slave_id=$package_id;
                    if(!$binder->insert()){
                        throw new \RuntimeException("Can't write StockToServicePackageBinder : ".print_r($binder->getErrorSummary(true),true));
                    }
                }
                
                foreach ($stock['services'] as $service_id){
                    $binder=new StockToCheckedServiceBinder();
                    $binder->master_id=$model->id;
                    $binder->slave_id=$service_id;
                    if(!$binder->insert()){
                        throw new \RuntimeException("Can't write StockToCheckedServiceBinder : ".print_r($binder->getErrorSummary(true),true));
                    }
                }
                
                if(!is_array($stock['rate'])){
                    $rate=Rate::find()->where(['id'=>$stock['rate']])->one();
                    if($rate){
                        $rate->_stock__id=''.$model['id'];
                        //BaseConsole::stdout(print_r($rate->attributes,true),PHP_EOL);
                        if(!$rate->saveLikeItem()){
                            throw new Exception("Can't write rate with id={$rate->id}:".print_r($rate->getErrorSummary(true),true));
                        }
                    }else{
                        throw new \RuntimeException("Can't find rate with id={$rate->id}.");
                    }
                }else{
                    foreach ($stock['rate'] as $id){
                        $rate=Rate::find()->where(['id'=>$id])->one();
                        if($rate){
                            $rate->_stock__id=''.$model['id'];
                            if(!$rate->saveLikeItem()){
                                throw new Exception("Can't write rate with id={$rate->id}:".print_r($rate->getErrorSummary(true),true));
                            }
                        }else{
                            throw new \RuntimeException("Can't find rate with id=$id.");
                        }
                    }
                }
            }else{
                throw new Exception("Can't write stock with id=$rate->id:".print_r($rate->getErrorSummary(true),true));
            }
        }
    }
    
    public function importServices()
    {
        $path=$this->data_path.'/AdditionalService';
        
        $json=file_get_contents($path.'/AdditionalService.json');
        $items=Json::decode($json);
        
        foreach ($items as $item){
            $obj=new Service();
            $obj->id=$item['id'];
            $obj->_section__id=$item['_section__id'];
            $obj->active=$item['active'];
            $obj->name=$item['name'];
            //$obj->code=$item['code'];
            $obj->slx_id=$item['slx_product_nmb'];
            $obj->price=$item['price'];
            $result=$obj->saveLikeItem();
            if(!$result){
                throw new Exception("Can't write service with id=$obj->id:".print_r($obj->getErrorSummary(true),true));
            }
        }
    }
    
    public function importRateToSiteBinder()
    {
        $path=$this->data_path.'/Rate';
        
        $json=file_get_contents($path.'/RateToSiteBinder.json');
        $items=Json::decode($json);
        
        foreach ($items as $item){
            $obj=new RateToSiteBinder();
            $obj->master_id=$item['_master__id'];
            $obj->slave_id=$item['_slave__id'];
            
            $result=$obj->insert();;
            if(!$result){
                throw new Exception("Can't write rate to site binder with id=$obj->id:".print_r($obj->getErrorSummary(true),true));
            }
        }
    }
    
    public function importRates()
    {
        $path=$this->data_path.'/Rate';
        
        $json=file_get_contents($path.'/Rate.json');
        $items=Json::decode($json);
        
        foreach ($items as $item){
            $obj=new Rate();
            $obj->id=$item['id'];
            $obj->_section__id=$item['_section__id'];
            $obj->active=$item['active'];
            $obj->name=$item['name'];
            //$obj->code=$item['code'];
            $obj->slx_id=$item['slx_product_nmb'];
            $obj->price=$item['price'];
            $result=$obj->saveLikeItem();
            if(!$result){
                throw new Exception("Can't write rate with id=$obj->id:".print_r($obj->getErrorSummary(true),true));
            }
        }
        
        $json=file_get_contents($path.'/Section.json');
        $items=Json::decode($json);
        
        foreach ($items as $item){
            $obj=new RateSection();
            $obj->id=$item['id'];
            $obj->__id=$item['__id'];
            $obj->active=$item['active'];
            $obj->name=$item['name'];
            //$obj->code=$item['code'];
            $result=$obj->saveLikeItem();
            if(!$result){
                throw new Exception("Can't write rate section with id=$obj->id:".print_r($obj->getErrorSummary(true),true));
            }
        }
    }
    
    public function importSites()
    {
        $path=$this->data_path.'/Site';
        
        $json=file_get_contents($path.'/Site.json');
        $items=Json::decode($json);
        
        foreach ($items as $item){
            $obj=new Site();
            $obj->id=$item['id'];
            $obj->_section__id=$item['_section__id'];
            $obj->active=$item['active'];
            $obj->name=$item['name'];
            $obj->url=$item['url'];
            //$obj->code=$item['code'];
            $result=$obj->saveLikeItem();
            if(!$result){
                throw new Exception("Can't write site with id=$obj->id:".print_r($obj->getErrorSummary(true),true));
            }
        }
        
        $json=file_get_contents($path.'/Section.json');
        $items=Json::decode($json);
        
        foreach ($items as $item){
            $obj=new SiteSection();
            $obj->id=$item['id'];
            $obj->__id=$item['__id'];
            $obj->active=$item['active'];
            $obj->name=$item['name'];
            //$obj->code=$item['code'];
            $result=$obj->saveLikeItem();
            if(!$result){
                throw new Exception("Can't write site section with id=$obj->id:".print_r($obj->getErrorSummary(true),true));
            }
        }
    }
}