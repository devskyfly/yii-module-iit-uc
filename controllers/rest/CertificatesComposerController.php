<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use devskyfly\php56\types\Vrbl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use devskyfly\php56\types\Arr;
use yii\helpers\Json;

use devskyfly\yiiModuleIitUc\components\CertificatesComposer;


/**
 * Rest api class
 */
class CertificatesComposerController extends CommonController
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
     *      stock: number,
     *      names: string[],
     *      price: number[],
     *      slx_ids: string[],
     *      sites: [
     *          [
     *              id: number,
     *              name: string
     *          ],...
     *      ]
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

            $composer = new CertificatesComposer();
            $result = $composer->compose($data);
            //$result = $composer->unique($result);
            $result = Arr::getValues($result);

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
}
