<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\components\StocksManager;
use devskyfly\yiiModuleIitUc\models\site\Site;
use devskyfly\yiiModuleIitUc\models\siteCalcGroup\SiteCalcGroup;

class SitesCalcGroupsController extends CommonController
{
    public function actionIndex()
    {
        try {
                $result=[];
                $sites = Site::find()
                ->where(['active' => 'Y','flag_show_in_calc' => 'Y'])
                ->all();
                
                foreach ($rates as $rate) {
                    $rootRate = RatesManager::getRootRate($rate);
                    $stock = StocksManager::getStockByRate($rootRate);
                    $result[] = [
                        "id" => $rate->id,
                        "name" => $rate->name,
                        //"slx_id" => $rate->slx_id,
                        //"stock" => $stock->stock,
                        "calc_name" =>$rate->calc_name,
                        //"calc_group" =>,
                        "calc_show" => true,
                    ];
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

    public function actionGroups()
    {
        $result = [];
        try {
            $items = SiteCalcGroup::find()
            ->where(['active'=>'Y'])
            ->orderBy(['name'=>SORT_ASC,'sort'=>SORT_ASC])
            ->all();

            foreach ($items as $item) {
                $result[] = [
                    "id" => $item->id,
                    "name" => $item->name,
                    "calc_sort" => $item->sort,
                ];
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
