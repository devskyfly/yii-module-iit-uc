<?php
namespace devskyfly\yiiModuleIitUc\components\order;

use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\components\PowersManager;
use devskyfly\yiiModuleIitUc\components\RatesBundlesManager;
use devskyfly\yiiModuleIitUc\helpers\ModelsFilter;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use yii\helpers\ArrayHelper;

class BundleOrderBuilder extends AbstractOrderBuilder
{
    /**
     *
     * @var RateBundle
     */
    public $bundle = null;
    
    public function build()
    {
        $this->rates = RatesBundlesManager::formChain($this->bundle, $this->rates, $this->promoListCmp, $this->bindListCmp);
        $this->clientTypes = $this->getClientTypes();
        
        $this->formRatesPackages();
        if ($this->emmiter == self::EMMITERS[1]) {
            $this->excludePackagedRates();
        }
        $this->formRatesChain();
        return $this;
    }

    //#
    protected function formRatesChain()
    {
        $result = [];
        $client_types = static::getClientTypes($this->rates);

        $itr = 0;
        foreach ($this->rates as $rate) {
            $itr++;

            //Stock
            $stock = null;
            if (!Vrbl::isEmpty($rate->_stock__id)) {
                $stock = Stock::find()
                    ->where([
                        'active' => Stock::ACTIVE,
                        'id' => $rate->_stock__id
                    ])
                    ->one();

                if (Vrbl::isEmpty($stock)) {
                    throw new \RuntimeException('Parameter $stock is empty.');
                }
            }

            $powers_packages_ids = [];
            $bundle_powers_packages_ids = [];
            $rates_packages_ids = [];

            if (Obj::isA($rate, RateBundle::class)) {
                $parent_rate = RatesBundlesManager::getParentRate($rate);
                $ratePackage = $this->getRatePackage($parent_rate);
            }  else {
                $ratePackage = $this->getRatePackage($rate);
            }

            if ($ratePackage) {
                $rates_packages_ids[] = $ratePackage->id;
            }
            
            //Powers packages definition
            if (Obj::isA($rate, Rate::class)) {
                $powersPackages = RateToPowerPackageBinder::getSlaveItems($rate->id);
                foreach ($powersPackages as $powerPackage) {
                    if ($powerPackage->active == 'Y') {
                        $powers_packages_ids[] = $powerPackage->id;
                    }
                }
            }

            if (Obj::isA($rate, RateBundle::class)) {
                $extensions = RatesBundlesManager::getBundleRates($rate);
                $extensions = ModelsFilter::getActive($extensions);
                $bundle_powers_packages_ids = [];

                foreach ($extensions as $extension) {
                    $powersPackages = PowersManager::getPackages($extension);
                    $powersPackages = ModelsFilter::getActive($powersPackages);
                    foreach ($powersPackages as $powerPackage) {
                        $bundle_powers_packages_ids[] = $powerPackage->id;
                    }
                }
                $powers_packages_ids = ArrayHelper::merge($powers_packages_ids, $bundle_powers_packages_ids);
           }

            $powers_packages_ids = array_unique($powers_packages_ids);
            
            
            $result[]=[
                "id" => (Obj::isA($rate, RateBundle::class))?(1000+$rate->id):$rate->id,
                "name" => $rate->name,
                "calc_name" => $rate->calc_name,
                "slx_id" => $rate->slx_id,
                "price" => Nmbr::toDoubleStrict($rate->price),
                "powers_packages" => $powers_packages_ids,
                "rates_packages" => $rates_packages_ids,
                "required_powers" => [],
                "stock_id" => Vrbl::isNull($stock)?'':$stock->stock,
                "stock_bind_id" => Vrbl::isNull($stock)?'':$stock->id,
                "client_types" => $itr==1?$client_types:[],
                "required_license" => $rate->flag_for_license=='Y'?true:false
            ];
        }

        $this->ratesChain = $result;
    }
}