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

class CertificatesComposerController extends CommonController
{
    public const EMMITERS = ['rates','sites'];

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
        return parent::beforeAction($action);
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


    protected function compose($data, $emmiter)
    {
        $result = [];

        if (!in_array($emmiter, self::EMMITERS)) {
            throw new \OutOfBoundsException('Param $emmiter is out of the self::EMMITERS bound.');
        }
        
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
                'salesListCmp'=>$salesCmp
            ]);

            $chain = $orderBuilder->build()->getRatesChain();    

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
                'price' => $price,
                'slx_ids' => $slxIds,
            ];

            $rate = RatesManager::getBySlxId($item["slx_id"]);
            $recomended_services = RateSManager::getRecomendedServices($rate);

            
            $services = [];
            if (!Vrbl::isEmpty($recomended_services)) {
                foreach ($recomended_services as $recomended_service) {
                    $services[] = [
                        "name" =>$recomended_service->name,
                        "price" =>$recomended_service->price,
                        "slx_id" =>$recomended_service->slx_id
                    ];
                }
                $result_item['services'] = $services;
            }

            $result[] = $result_item;

            //Add certificate for fiz by condition
            if ($emmiter == "sites") {
                if ($stockSet['stock'] == 15) {
                    $baseRate = RatesManager::getBaseRate();
                    $baseRateSites = SitesManager::getByRate($baseRate);
                    $baseRateSitesIds = [];
                    
                    foreach ($baseRateSites as $baseSite){
                        $baseRateSitesIds[] = $baseSite["id"];
                    }

                    $diff_result = array_diff($stockSet['sites'], $baseRateSitesIds); 
                    //codecept_debug("####".print_r($diff_result, true));
                    if (empty($diff_result)) {
                    //if (true) {

                        $fizRate = RatesManager::getFizRate();
                        $result[]=[
                            'names' => [$fizRate->name],
                            'price' => $fizRate->price,
                            'slx_ids' => [$fizRate->slx_id],
                        ];
                    }
                }
            }
        }

        return $result;
    }

    public function actionByRates()
    { 
        try {
                $data = $this->getRequestData();
                
                if (Vrbl::isEmpty($data)) {
                    throw new \InvalidArgumentException('Param $data is epmty.');
                }

                if (!Arr::isArray($data)) {
                    throw new \InvalidArgumentException('Param $data is not array.');
                }

                $result = $this->compose($data, 'rates');
                
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

            $result = $this->compose($data, 'sites');
            
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
