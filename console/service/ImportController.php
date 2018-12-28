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
            $this->importStocks();
            $this->import();
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
    
    public function importStocks()
    {
        $stocks=[
            ['name'=>'Базовый сертификат','stock'=>'15',"client_type"=>"['UR','IP','FIZ']",'rate'=>2],
            ['name'=>'ОФД','stock'=>'42',"client_type"=>"['UR','IP']",'rate'=>18],
            //['name'=>'ОФД-Я','stock'=>'37','rate'=>],
            ['name'=>'СМЭВ','stock'=>'22',"client_type"=>"['UR']",'rate'=>[20,28]],
            ['name'=>'ЕГАИС','stock'=>'25',"client_type"=>"['UR','IP']",'rate'=>3],
            ['name'=>'Маркировка','stock'=>'92',"client_type"=>"['UR','IP']",'rate'=>27],
            ['name'=>'Квал. для физ. лиц','stock'=>'39',"client_type"=>"['FIZ']",'rate'=>1],
        ];
        
        foreach ($stocks as $stock){
            $model=new Stock();
            $model->active='Y';
            $model->name=$stock['name'];
            $model->stock=$stock['stock'];
            $model->client_type=$stock['client_type'];
            
            if($model->saveLikeItem()){
                if(!is_array($stock['rate'])){
                    $rate=Rate::find()->where(['id'=>$stock['rate']])->one();
                    if($rate){
                        $rate->_stock__id=''.$model['id'];
                        BaseConsole::stdout(print_r($rate->attributes,true),PHP_EOL);
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
                BaseConsole::stdout(print_r($obj->getErrors(),true).PHP_EOL);
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
                BaseConsole::stdout(print_r($obj->getErrors(),true).PHP_EOL);
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
                BaseConsole::stdout(print_r($obj->getErrors(),true).PHP_EOL);
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
                BaseConsole::stdout(print_r($obj->getErrors(),true).PHP_EOL);
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
                BaseConsole::stdout(print_r($obj->getErrors(),true).PHP_EOL);
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
                BaseConsole::stdout(print_r($obj->getErrors(),true).PHP_EOL);
            }
        }
    }
}