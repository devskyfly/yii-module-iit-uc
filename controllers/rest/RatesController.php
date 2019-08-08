<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;

/**
 * Rest api class
 */
class RatesController extends AbstractRatesController
{
    /**
     * Return rates
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
     * @param string[] $ids
     */
    public function actionIndex(array $ids = null)
    {
        try {
            if (!Vrbl::isNull($ids)) {
                //Chain
                $result = $this->getChain($ids);
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
