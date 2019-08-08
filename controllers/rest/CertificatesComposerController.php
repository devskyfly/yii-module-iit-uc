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
use devskyfly\php56\types\Nmbr;

/**
 * Rest api class
 */
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

        return parent::behaviors();
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Return composed certificates array on post request
     * 
     * POST RAW
     * 
     * Request:
     * [
     *  [
     *      "stock":number,
     *      "slx_ids":string[],
     *      "sites":number[]
     *  ],...
     * ]
     *
     * Return json:
     * [
     *  [
     *      names: string[],
     *      price: number[],
     *      slx_ids: string[],
     *      services: [
     *                  [
     *                      name: string,
     *                      price: number,
     *                      slx_id: string,
     *                      comment: string
     *                  ],...
     *      ]
     *  ],...
     * ]
     */
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
            $result = $this->unique($result);
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

    protected function unique(&$result)
    {
        return $result;
        return array_unique($result);
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
            $result_item = $this->formResultItem($chain, $orderBuilder);
            $rate = RatesManager::getBySlxId($slxId);
            
            
            //Add certificate for fiz by condition in sites action
            if ($emmiter == "sites") {
                $this->applySites($stockSet, $result);
            }
            $services = $this->applyServices($rates);
            $result_item['services'] = $services;
            $result[] = $result_item;
        }
        //$this->clearResult($result);
        //$result = array_unique($result);
        $result = array_map("unserialize", array_unique(array_map("serialize", $result)));
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
                if ($recomended_service
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

    protected function applySites($stockSet, &$result)
    {
        if (isset($stockSet['sites'])&&(!Vrbl::isEmpty($stockSet['sites']))) {
            if ($stockSet['stock'] == 15) {
                $baseRate = RatesManager::getBaseRate();
                $baseRateSites = SitesManager::getByRate($baseRate);
                $baseRateSitesIds = [];
                
                foreach ($baseRateSites as $baseSite){
                    $baseRateSitesIds[] = $baseSite["id"];
                }

                $diff_result = array_diff($stockSet['sites'], $baseRateSitesIds); 
                if (empty($diff_result)) {
                    $fizRate = RatesManager::getFizRate();
                    $result_item = [
                        'names' => [Vrbl::isEmpty($fizRate->calc_name)?$fizRate->name:$fizRate->calc_name],
                        'price' => Nmbr::toInteger($fizRate->price),
                        'slx_ids' => [$fizRate->slx_id],
                    ];
                    $services = $this->applyServices([$fizRate]);
                    $result_item['services'] = $services;
                    $result[] = $result_item;
                }
            }
        }
    }
}
