<?php
namespace devskyfly\yiiModuleIitUc\components;

use yii\base\BaseObject;

use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use yii\helpers\ArrayHelper;
use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\components\order\RateOrderBuilder;
use devskyfly\yiiModuleIitUc\components\RatesBundlesManager;
use devskyfly\yiiModuleIitUc\models\site\Site;

class CertificatesComposer extends BaseObject
{
    public function unique(&$result)
    {
        return $result;
        return array_unique($result);
    }

    protected function sort()
    {
        return function($a, $b) {
            if ($a['price'] == $b['price']) {
                return 0;
            }
            return ($a['price'] < $b['price']) ? -1 : 1;
        };
    }

    public function compose($data)
    {
        $result = [];
        //Rates
        $result_rates_part = $this->formRates($data);
        //Post executions
        $result_rates_part = array_map("unserialize", array_unique(array_map("serialize", $result_rates_part)));
        $this->editeResultIfOnlyFiz($result_rates_part);
        usort($result_rates_part, $this->sort());
        $result_bundles_part = $this->formBundles($data);
        usort($result_bundles_part, $this->sort());
        
        $result = array_merge($result_rates_part, $result_bundles_part);
        return $result;
    }

    protected function formRates($data)
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

            array_unique($rates);

            $promoListCmp = new PromoList();
            $bindListCmp = new BindsList();
            $salesCmp =new SalesList();

            $orderBuilder = new RateOrderBuilder([
                'rates'=>$rates,
                'promoListCmp'=>$promoListCmp,
                'bindListCmp'=>$bindListCmp,
                'salesListCmp'=>$salesCmp,
                'emmiter' => RateOrderBuilder::EMMITERS[0] //constructor
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
        //$result = array_unique($result);
        return $result;
    }

    protected function formBundles($data) 
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
                
                $bundle_extensions = [];

                foreach ($bundle_rates as $bundle_rate) {
                    $bundle_extensions[] = (Vrbl::isEmpty($bundle_rate->calc_name))?$bundle_rate->name:$bundle_rate->calc_name;
                }

                sort($bundle_extensions);

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
                $result_item["oldprice"] = $price + Nmbr::toDouble($bundle->sale);
                $result_item["stock"] = Nmbr::toInteger($stock->stock);
                $result_item["slx_ids"] = $slx_ids;
                $result_item["sites"] = []; // Вопрос в реализации
                $result_item["services"] = $this->applyServices($all_rates);
                $result_item["bundle_extensions"] = $bundle_extensions;
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
                    $result[] = ["name"=>Vrbl::isEmpty($site->calc_name)?$site->name:$site->calc_name, 'id'=>$site->id];
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