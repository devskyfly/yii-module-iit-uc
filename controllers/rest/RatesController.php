<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\ChainHelper;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\RatesBundlesManager;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\yiiModuleIitUc\helpers\ModelsFilter;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;

/**
 * Rest api class
 */
class RatesController extends CommonController
{
    /**
     * Return all rates
     * GET
     * 
     * [
     *  [
     *      id: number,
     *      name: string,
     *      slx_id: string,
     *      price: number
     *  ],...
     * ]
     * 
     * Or return rates chain
     * 
     * GET 
     * [
     *  [
     *      calc_nane: string,
     *      client_tipes: string[],
     *      id: number,
     *      name: string,
     *      powers_packages: number[],
     *      price: number,
     *      rates_packages: number[],
     *      required_licence: false,
     *      required_powers: number[],
     *      slx_id: string,
     *      stock_bind_id: number,
     *      stock_id: number
     *  ]
     * ]
     * 
     * @param string[] $ids
     */
    public function actionIndex(array $ids = null)
    {
        $result = [];
        try {
            $promoListCmp = new PromoList();
            $bindListCmp = new BindsList();
            $salesCmp = new SalesList();

            if (!Vrbl::isNull($ids)) {
                //Chain
                
                $bundle = RatesBundlesManager::findBundleBySlxIds($ids);
                
                if ($bundle) {
                    $rates = [];
                    
                    foreach ($ids as $id) {
                        $rate = RatesManager::getBySlxId($id);
                        if (!Vrbl::isNull($rate)) {
                            $rates[] = $rate;
                        }
                    }
                    
                    $rates = ModelsFilter::getActive($rates);
                    
                    $chain = RatesBundlesManager::formChain($bundle, $rates, $promoListCmp, $bindListCmp);
                    $result = ChainHelper::formChainToApiFormat($chain);
                } else {
                    $rates=[];

                    //Models definition
                    foreach ($ids as $id) {
                        $rate = RatesManager::getBySlxId($id);
                        if (!Vrbl::isNull($rate)) {
                            $rates[] = $rate;
                        } else {
                            throw NotFoundHttpException('Model with id=\'' . $id . '\' does not exist.');
                        }
                    }

                    //This is by using OrderBuilder
                    $ratesChainCmp = new RateOrderBuilder([
                        'rates'=>$rates,
                        'promoListCmp'=>$promoListCmp,
                        'bindListCmp'=>$bindListCmp,
                        'salesListCmp'=>$salesCmp,
                        'emmiter'=> OrderBuilder::EMMITERS[1]
                    ]);
            
                    $result = $ratesChainCmp->build()->getRatesChain();
                }
                
            } else {
                //All rates
                $rates = Rate::find()
                ->where(['active' => 'Y'])
                ->all();
                
                foreach ($rates as $rate) {

                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        "slx_id" => $rate->slx_id,
                        "price" => Nmbr::toDoubleStrict($rate->price),
                    ];
                }
                
            }
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
}
