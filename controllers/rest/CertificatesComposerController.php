<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\yiiModuleIitUc\components\OrderBuilder;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use devskyfly\php56\types\Arr;
use yii\helpers\Json;
use devskyfly\yiiModuleIitUc\components\SitesManager;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;
use devskyfly\yiiModuleIitUc\components\RatesBundlesManager;
use devskyfly\yiiModuleIitUc\models\site\Site;

/**
 * Rest api class
 */
class CertificatesComposerController extends CommonController
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'calc' => ['POST']
                ]
            ],
        ], parent::behaviors());

        return parent::behaviors();
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Return composed certificates array on post request
     * 
     * POST RAW
     * 
     * Request:
     * [
     *  [
     *      "stock":number,
     *      "slx_ids":string[],
     *      "sites":number[]
     *  ],...
     * ]
     *
     * Return json:
     * [
     *  [
     *      stock: number,
     *      names: string[],
     *      price: number[],
     *      slx_ids: string[],
     *      sites: [
     *          [
     *              id: number,
     *              name: string
     *          ],...
     *      ]
     *      services: [
     *                  [
     *                      name: string,
     *                      price: number,
     *                      slx_id: string,
     *                      comment: string
     *                  ],...
     *      ]
     *  ],...
     * ]
     */
    public function actionBySites()
    {
        try {
            $data = $this->getRequestData();
            
            if (Vrbl::isEmpty($data)) {
                throw new \InvalidArgumentException('Param $data is epmty.');
            }

            if (!Arr::isArray($data)) {
                throw new \InvalidArgumentException('Param $data is not array.');
            }

            $result = $this->compose($data);
            $result = $this->unique($result);
            $result = Arr::getValues($result);

            \codecept_debug($result);
            $this->asJson($result);
        } catch (\Exception $e) {
            Yii::error($e, self::class);
            if (YII_DEBUG) {
                throw $e;
            } else {
                throw new NotFoundHttpException();
            }
        }
    }

    protected function unique(&$result)
    {
        return $result;
        return array_unique($result);
    }

    /**
     *
     * @return []
     */
    protected function getRequestData()
    {
        $request = \Yii::$app->request;
        
        if(!YII_ENV_TEST){
            if ($request->contentType == "multipart/form-data") {
                $data = $request->post();
            } else {
                $json = file_get_contents("php://input");
                $data = Json::decode($json, true);
            }
        } else {
            $data = $_POST;
        }
        return $data;
    }


    protected function compose($data)
    {
        $result = [];
        
        //Rates
        foreach ($data as $stockSet) {
            $rates = [];

            foreach ($stockSet['slx_ids'] as $slxId) {
                $rate = Rate::getBySlxId($slxId);
                if (Vrbl::isNull($rate)) {
                    throw new \InvalidArgumentException('Varible $rate is null');
                }
                $rates[] = $rate;
            }

            array_unique($rates);

            $promoListCmp = new PromoList();
            $bindListCmp = new BindsList();
            $salesCmp =new SalesList();

            $orderBuilder = new OrderBuilder([
                'rates'=>$rates,
                'promoListCmp'=>$promoListCmp,
                'bindListCmp'=>$bindListCmp,
                'salesListCmp'=>$salesCmp,
                'emmiter' => OrderBuilder::EMMITERS[0] //constructor
            ]);

            $chain = $orderBuilder->build()->getRatesChain();
            $result_item = $this->formResultItem($chain, $orderBuilder);
            $result_item['stock'] = Nmbr::toInteger($stockSet['stock']);
            $result_item['type'] = "rate";
            
            $rate = RatesManager::getBySlxId($slxId);
            
            $sites = $this->applySites($stockSet, $result);
            $result_item['sites'] = $sites;

            $services = $this->applyServices($rates);
            $result_item['services'] = $services;

            $result[] = $result_item;
        }

        //Post works
        
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));
        $this->editeResultIfOnlyFiz($result);

        $result_bundles_part = $this->getBundles($data);
        $result = array_merge($result, $result_bundles_part);
        return $result;
    }

    protected function getBundles($data) 
    {
        $result = [];
        foreach ($data as $stockSet) {
            $rates = [];

            foreach ($stockSet['slx_ids'] as $slxId) {
                $rate = Rate::getBySlxId($slxId);
                if (Vrbl::isNull($rate)) {
                    throw new \InvalidArgumentException('Varible $rate is null');
                }
                $rates[] = $rate;
            }

            $bundles = RatesBundlesManager::getRatesBundlesByRates($rates);

            foreach ($bundles as $bundle) {
                $result_item = [];
                
                $stock = RatesBundlesManager::getStock($bundle);
                $bundle_rates = RatesBundlesManager::getBundleRates($bundle);
                $diffs = RatesBundlesManager::getRateBundleValideRates($bundle, $rates);
                $all_rates = array_merge($bundle_rates, $diffs);
                $all_rates = array_unique($all_rates);

                $names = [];
                $names[] = (Vrbl::isEmpty($bundle->calc_name))?$bundle->name:$bundle->calc_name;

                $price = 0;
                $price = Nmbr::toDouble($bundle->price);

                $slx_ids = [];

                $slx_ids[] = $bundle->slx_id;

                foreach ($diffs as $diff) {
                    $names[] = (Vrbl::isEmpty($diff->calc_name))?$diff->name:$diff->calc_name;
                    $slx_ids[] = $diff->slx_id;
                    $price += Nmbr::toDouble($diff->price);
                }

                $result_item["type"] = "bundle";
                $result_item["names"] = $names;
                $result_item["price"] = $price;
                $result_item["stock"] = Nmbr::toInteger($stock->stock);
                $result_item["slx_ids"] = $slx_ids;
                $result_item["sites"] = []; // Вопрос в реализации
                $result_item["services"] = $this->applyServices($all_rates);
                $result[] = $result_item;
            }
        }

        return $result;
    }

    protected function formResultItem($chain, $orderBuilder)
    {
        $slxIds = [];    
        $price = 0;
        $names = [];
        
        $i=0;
        $lng = Arr::getSize($chain);
        foreach ($chain as $item) {
            $i++;
            $slxIds[] = $item["slx_id"];
            $price = $price + $item["price"];
            $names[] = (!Vrbl::isEmpty($item["calc_name"]))?$item["calc_name"]:$item["name"];
        }

        $price = $price - $orderBuilder->sale;
        $result_item = [
            'names' => $names,
            'price' => Nmbr::toInteger($price),
            'slx_ids' => $slxIds,
        ];
        return $result_item;
    }

    /**
     * Undocumented function
     *
     * @param Rate $rate
     * @param [] $result
     * @return void
     */
    protected function applyServices($rates)
    {       
            $result = [];
            $services = [];
            $recomended_services = [];
            foreach ($rates as $rate) {
                $recomended_services =ArrayHelper::merge($recomended_services, RatesManager::getRecomendedServices($rate));
            }

            foreach ($recomended_services as $recomended_service) {
                if ((!Vrbl::isNull($recomended_service))
                &&$recomended_service->active=="Y") {
                    $services[] = $recomended_service;
                } 
            }

            $services = array_unique($services);
            
            foreach ($services as $service) {
                $result[]=[
                    "name" => $service->name,
                    "price" => Nmbr::toInteger($service->price),
                    "slx_id" => $service->slx_id,
                    "comment" => Vrbl::isNull($service->comment)?"":$service->comment
                ];
            }

            
            return $result;
    }

    protected function applySites($stockSet)
    {
        $result = [];
        if (isset($stockSet['sites'])
        &&(!Vrbl::isEmpty($stockSet['sites']))) {
            foreach ($stockSet['sites'] as $id) {
                $site = Site::getById($id);
                if (!Vrbl::isNull($site)
                &&($site->active=="Y")) {
                    $result[] = ["name"=>Vrbl::isEmpty($site->calc_name)?$site->name:$site->calc_name,'id'=>$site->id];
                }
            }
        }
        return $result;
    }

    protected function editeResultIfOnlyFiz(&$compose)
    {
        $neadedStocks = [15,39];
        $stocks = ArrayHelper::getColumn($compose,'stock');
        
        $base = array_filter($compose, function($e){
            if($e['stock']==15) {
                return true;
            }
        });
        if (Vrbl::isEmpty(array_diff($neadedStocks, $stocks))) {
            $compose = array_filter($compose, function($itm) use ($base){
                if(!Vrbl::isEmpty($base)){
                    if (!Vrbl::isEmpty($base[0]['names'])) {
                        if ($itm['stock']==39) {
                            return false;
                        }
                    } 
                } 
                return true;
            });
        }
    }
}
