<?php
namespace devskyfly\yiiModuleIitUc\console\service;

use devskyfly\yiiModuleIitUc\models\power\Power;
use devskyfly\yiiModuleIitUc\models\power\PowerSection;
use devskyfly\yiiModuleIitUc\models\powerPackage\PowerPackage;
use devskyfly\yiiModuleIitUc\models\powerPackage\PowerPackageToPowerBinder;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\rate\RateSection;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\rate\RateToSiteBinder;
use devskyfly\yiiModuleIitUc\models\service\Service;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackage;
use devskyfly\yiiModuleIitUc\models\servicePackage\ServicePackageToServiceBinder;
use devskyfly\yiiModuleIitUc\models\site\Site;
use devskyfly\yiiModuleIitUc\models\site\SiteSection;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\models\stock\StockToCheckedServiceBinder;
use devskyfly\yiiModuleIitUc\models\stock\StockToServicePackageBinder;
use PHPExcel_IOFactory;
use Yii;
use yii\console\Controller;
use yii\db\Exception;
use yii\helpers\BaseConsole;
use yii\helpers\Json;

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
        $this->data_path=__DIR__."/../../service/data/files/";
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
            $this->importRateToSiteBinder();  
            $this->importPowers();
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
    
    public function importPowers()
    {
        $sections_names=[
            "6,4"=>"АЭТП и ФЭТП|ФЭТП",
            "20"=>"СМЭВ",
            "23"=>"АСТ ГОЗ",
            "26"=>"Росреестра",
            "34"=>"ФРДО",
        ];
        
        //BaseConsole::stdout(print_r($files,true).PHP_EOL);
        
        $path=$this->data_path.'/Powers';
        $files=glob($path.'/*.xls');
        
        foreach ($files as $file){  
            $basename=basename($file,'.xls');
            $ids=explode(',', $basename);
            
            $objPHPExcel = PHPExcel_IOFactory::load($file);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            
            $section=new PowerSection();
            $section->active='Y';
            $section->name=$sections_names[$basename];
            if(!$section->saveLikeItem()){
                throw new Exception('Can\'t save PowerSection: '.print_r($section->getErrorSummary(true),true));
            }
            $powers_ids=[];
            
            foreach ($sheetData as $item){
                if(empty($item['A'])){
                    break;
                }
                $power=new Power();
                $power->active='Y';
                $power->_section__id=$section->id;
                $power->name=$item['A'];
                $power->slx_id=$item['B'];
                if(!$power->saveLikeItem()){
                    throw new Exception('Can\'t save Power: '.print_r($power->getErrorSummary(true),true));
                }
                $powers_ids[]=$power->id;
            }
            
            foreach ($ids as $id){
                $power_package=new PowerPackage();
                $power_package->active='Y';
                $power_package->name=$section->name;
                $power_package->select_type='MULTI';
                if(!$power_package->saveLikeItem()){
                    throw new Exception('Can\'t save power package: '.print_r($power_package->getErrorSummary(true),true));
                }
                
                foreach ($powers_ids as $powers_id){
                    $binder=new PowerPackageToPowerBinder();
                    $binder->master_id=$power_package->id;
                    $binder->slave_id=$powers_id;
                    if(!$binder->insert()){
                        throw new Exception('Can\'t save binder: '.print_r($binder->getErrorSummary(true),true));
                    }
                }
                
                
                $rate=Rate::find()->where(['id'=>$id])->one();
                if(!$rate){throw new \RuntimeException("Can't find rate with id={$id}");}
                
                $rate_to_power_package_binder=new RateToPowerPackageBinder();
                
                $rate_to_power_package_binder->master_id=$rate->id;
                $rate_to_power_package_binder->slave_id=$power_package->id;
                
                if(!$rate_to_power_package_binder->insert()){
                    throw new Exception('Can\'t save binder: '.print_r($rate_to_power_package_binder->getErrorSummary(true),true));
                }
                
            }
        }
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