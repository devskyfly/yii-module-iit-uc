<?php
namespace devskyfly\yiiModuleIitUc\components\order;

use devskyfly\php56\libs\arr\Intersect;
use yii\base\BaseObject;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\php56\types\Obj;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Arr;
use devskyfly\yiiModuleIitUc\components\RatePackageManager;
use yii\helpers\Json;

abstract class AbstractOrderBuilder extends BaseObject
{
    const EMMITERS = ["constructor", "order"];

    public $emmiter = "";
    
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
     * Sale value
     *
     * @var integer
     */
    public $sale = 0;

    /**
     * SalesList cmp
     *
     * @var SaleList
     */
    public $salesListCmp = null;
    
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

    /**
     * 
     * @var []
     */
    protected $ratesPackages=[];

    public function init()
    {
        parent::init();

        if (!in_array($this->emmiter, self::EMMITERS)) {
            throw new \OutOfRangeException('Property $emmiter is out of range.');
        }

        foreach ($this->rates as $rate) {
            if (!(Obj::isA($rate, Rate::class))) {
                throw new \InvalidArgumentException('Param  $model is not '.Rate::class.' type.');
            }
        }

        if (Vrbl::isNull($this->promoListCmp) && !(Obj::isA($this->promoListCmp, PromoList::class))){
            throw new \InvalidArgumentException('Param $promoList is not '.PromoList::class.' type.');
        }

        if (Vrbl::isNull($this->promoListCmp) && !(Obj::isA($this->bindListCmp, BindsList::class))){
            throw new \InvalidArgumentException('Param $bindListCmp is not '.BindsList::class.' type.');
        }

        if (Vrbl::isNull($this->promoListCmp) && !(Obj::isA($this->salesListCmp, SalesList::class))){
            throw new \InvalidArgumentException('Param $salesListCmp is not '.SalesList::class.' type.');
        }
    }

    abstract public function build();

    public function getRatesChain()
    {
        return $this->ratesChain;
    }

    //#
    public function getClientTypes()
    {
        $client_types_arr = [];

        foreach ($this->rates as $item) {
            $client_types_arr = array_merge($client_types_arr, [Json::decode($item->client_type)]);
        }

        return Intersect::getIntersectOfArrayItems($client_types_arr);
    }

    protected function excludePackagedRates()
    {
        $rates = $this->rates;
        $rates = array_values($rates);
        
        $ratesCnt = Arr::getSize($rates);
        //throw new \Exception(print_r($this->editedRates,true));
        for ($i = 0; $i < $ratesCnt; $i++) {
            //try{
            $ratePackage = RatePackageManager::getByRate($rates[$i]);
            //}catch(\Exception $e){
            //    throw new \Exception(print_r($i,true));
            //}
            if (!Vrbl::isNull($ratePackage)) {
                unset($rates[$i]);
                $parentRate = Rate::getById($ratePackage->_parent_rate__id);
                if (Vrbl::isNull($parentRate)) {
                    throw new \RuntimeException('Param $parentRate is null.');
                }
            }
        }
        $this->rates = array_values($rates);
    }

    /**
     *
     * @return [["parentRate"=>Rate,"pacakge"=>RatePackage],...]]
     */
    protected function formRatesPackages()
    {
        $result=[];
        foreach($this->rates as $rate){
            $ratePackage = RatePackageManager::getByRate($rate);
            if (!Vrbl::isNull($ratePackage)) {
                $parentRate = Rate::getById($ratePackage->_parent_rate__id);
                if (Vrbl::isNull($parentRate)) {
                    throw new \RuntimeException('Parameter $parentRate is null.');
                }

                $result[] = ["parentRate"=>$parentRate,'package'=>$ratePackage];
            }
        }
        $this->ratesPackages=$result;
    }

    protected function getRatePackage($rate){
        if(!(Obj::isA($rate,Rate::class))){
            throw new \InvalidArgumentException('Param $rate is not '.Rate::class.' type.');
        }
        foreach($this->ratesPackages as $item){
            if($item['parentRate']['id']==$rate->id){
                return $item['package'];
            }
        }
        return null;
    }
}