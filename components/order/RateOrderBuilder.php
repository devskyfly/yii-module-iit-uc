<?php
namespace devskyfly\yiiModuleIitUc\components\order;

use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\stock\Stock;

class RateOrderBuilder extends AbstractOrderBuilder
{
    public function build()
    {
        $this->rates = RatesManager::getMultiChain($this->rates, $this->promoListCmp, $this->bindListCmp);
        $this->clientTypes=$this->getClientTypes();
        $this->sale = $this->salesListCmp->count($this->rates);
        //Может здесь надо снова обновить clien types
        $this->formRatesPackages();
        if ($this->emmiter==self::EMMITERS[1]) {
            $this->excludePackagedRates();
        }
        $this->formRatesChain();
        return $this;
    }

    //#
    protected function formRatesChain()
    {
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
            $rates_packages_ids = [];

            $ratePackage = $this->getRatePackage($rate);
            if ($ratePackage) {
                $rates_packages_ids[] = $ratePackage->id;
            }

            //Powers packages definition
            $powersPackages = RateToPowerPackageBinder::getSlaveItems($rate->id);
            foreach ($powersPackages as $powerPackage) {
                if ($powerPackage->active == 'Y') {
                    $powers_packages_ids[] = $powerPackage->id;
                }
            }

            $result[]=[
                "id" => $rate->id,
                "name" => $rate->name,
                "calc_name" => $rate->calc_name,
                "slx_id" => $rate->slx_id,
                "price" => Nmbr::toDoubleStrict($rate->price),
                "powers_packages" => $powers_packages_ids,
                "rates_packages" => $rates_packages_ids,
                "required_powers" => [],
                "stock_id" => Vrbl::isNull($stock)?'':$stock->stock,
                "stock_bind_id" => Vrbl::isNull($stock)?'':$stock->id,
                "client_types" => $itr==1?$this->clientTypes:[],
                "required_license" => $rate->flag_for_license=='Y'?true:false
            ];
        }

        $this->ratesChain=$result;
    }
}
