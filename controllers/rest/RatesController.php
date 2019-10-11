<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\components\ChainHelper;
use devskyfly\yiiModuleIitUc\components\RatesBundlesManager;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\helpers\ModelsFilter;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;

/**
 * Rest api class
 */
class RatesController extends AbstractRatesController
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
                    $chain = RatesBundlesManager::formChain($bundle, $rates);
                    $result = ChainHelper::formChainToApiFormat($chain);
                } else {
                    $result = $this->getChain($ids);
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
