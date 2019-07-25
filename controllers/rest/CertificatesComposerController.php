<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\components\PromoList;
use devskyfly\yiiModuleIitUc\components\BindsList;
use devskyfly\yiiModuleIitUc\components\SalesList;
use devskyfly\yiiModuleIitUc\components\OrderBuilder;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class CertificatesComposerController extends AbstractRatesController
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
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
    }

    public function actionIndex()
    {
        $request=\Yii::$app->request;
            if($request->contentType == "multipart/form-data"){
                $data = $request->post();
            }else{
                $json = file_get_contents("php://input");
                $data = Json::decode($json, $asArray = true);
            }

            if(Vrbl::isNull($data)){
                throw new \InvalidArgumentException('Param $data is epmty');
            }
            
            try {
                    //Chain
                    $result = $this->getChain($ids);
                    $stock = null;

                    foreach ($result as $item) {
                        $rate = Rate::getBySlxId($item['slx_id']);
                        if(Vrbl::isNull($rate)){
                            throw new InvalidArgumentException('Varible $rate is null.');
                        }
                        
                        $stock_id = Nmbr::toInteger($rate->_stock__id);
                        $stock = Stock::getById($stock_id);
                        if (!Vrbl::isNull($stock)) {
                            break;
                        }
                    }

                    if (Vrbl::isNull($stock)) {
                        throw new InvalidArgumentException('Varibale $stock is null.');
                    }

                    foreach ($result as &$item) {
                        $item['stock_id'] = $stock->stock;
                        //$item['stock_id'] = 15;
                    }
                    unset($item);

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
