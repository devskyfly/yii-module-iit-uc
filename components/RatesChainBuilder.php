<?php
namespace devskyfly\yiiModuleIitUc\components;

use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\php56\libs\arr\Intersect;
use devskyfly\php56\types\Obj;
use yii\helpers\Json;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Arr;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\php56\types\Nmbr;

class RatesChainBuilder extends BaseObject
{
    
    /**
     * Input array of rates
     *
     * @var Rates[]
     */
    public $rates = [];

    /**
     * PromoList cmp
     *
     * @var PromoList
     */
    public $promoListCmp = null;

    /**
     * BindList cmp
     *
     * @var BindList
     */
    public $bindListCmp = null;

    /**
     * Array or $rates after promoList, bindList use and so on.
     *
     * @var array
     */
    protected $editedRates=[];
    
    /**
     * Array for output
     *
     * @var array
     */
    protected $ratesChain=[];
    
    /**
     * 
     *
     * @var string[]
     */
    protected $clientTypes=[];

    protected $ratesPacakges=[];

    public function init()
    {
        parent::init();

        foreach ($this->rates as $rate) {
            if (!(Obj::isA($rate,Rate::class))) {
                throw new \InvalidArgumentException('Param  $model is not '.Rate::class.' type.');
            }
        }
        $this->rates=RatesManager::getMultiChain(\array_unique($this->rates));
        $this->editedRates=$this->rates;

        if (!(Obj::isA($this->promoListCmp, PromoList::class))) {
            throw new \InvalidArgumentException('Param $promoList is not '.PromoList::class.' type .');
        }

        /*if (!(Obj::isA($this->bindListCmp, BindList::class))) {
            throw new \InvalidArgumentException('Param $bindListCmp is not '.BindsList::class.' type.');
        }*/
    }

    public function build()
    {
        $this->clientTypes=$this->getClientTypes();
        $this->editedRates = RatesManager::getMultiChain($this->rates, $this->promoListCmp, $this->bindListCmp);
        //Может здесь надо снова обновить clien types
        $this->getRatesPackages();
        //$this->excludePackagedRates();
        $this->formRatesChain();
        return $this;
    }

    public function getRatesChain()
    {
        return $this->ratesChain;
    }

    //#
    public function getClientTypes()
    {
        $client_types_arr = [];

        foreach ($this->editedRates as $item) {
            $client_types_arr = array_merge($client_types_arr, [Json::decode($item->client_type)]);
        }

        return Intersect::getIntersectOfArrayItems($client_types_arr);
    }

    //#
    protected function formRatesChain()
    {
        $itr = 0;
                foreach ($this->editedRates as $rate) {
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

                    $powersPackages = RateToPowerPackageBinder::getSlaveItems($rate->id);
                    
                    //Powers packages definition
                    foreach ($powersPackages as $powerPackage) {
                        if ($powerPackage->active == 'Y') {
                            $powers_packages_ids[] = $powerPackage->id;
                        }
                    }


                    $result[]=[
                        "id"=>$rate->id,
                        "name"=>$rate->name,
                        "slx_id"=>$rate->slx_id,
                        "price"=>Nmbr::toDoubleStrict($rate->price),
                        "powers_packages"=>$powers_packages_ids,
                        "rates_packages"=>$itr==1?$rates_packages_ids:[],
                        "required_powers"=>[],
                        "stock_id"=>Vrbl::isNull($stock)?'':$stock->stock,
                        //"client_types"=>$itr==1?$intersected_clients_types:[],
                        "required_license"=>$rate->flag_for_license=='Y'?true:false
                    ];
                }

                $this->ratesChain=$result;
    }

   

    protected function excludePackagedRates()
    {
        $ratesCnt = Arr::getSize($this->editedRates);
        //throw new \Exception(print_r($ratesCnt,true));
        for ($i = 0; $i < $ratesCnt; $i++) {
            $ratePackage = RatePackageManager::getByRate($this->editedRates[$i]);
            if (!Vrbl::isNull($ratePackage)) {
                unset($this->editedRates[$i]);
                $parentRate = Rate::getById($ratePackage->_parent_rate__id);
                if (Vrbl::isNull($parentRate)) {
                    throw new \RuntimeException('Param $parentRate is null.');
                }
            }
        }
        $this->editedRates = array_values($this->editedRates);
    }

    /**
     *
     * @return [["parentRate"=>Rate,"pacakge"=>RatePackage],...]]
     */
    protected function getRatesPackages()
    {
        $result=[];
        foreach($this->editedRates as $rate){
            $ratePackage = RatePackageManager::getByRate($rate);
            if (!Vrbl::isNull($ratePackage)) {
                $parentRate = Rate::getById($ratePackage->_parent_rate__id);
                if (Vrbl::isNull($parentRate)) {
                    throw new \RuntimeException('Parameter $parentRate is null.');
                }

                $result[] = ["parentRate"=>$parentRate,'package'=>$ratePackage];
            }
        }
        return $result;
    }
}
