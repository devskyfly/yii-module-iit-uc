<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use Yii;
use yii\web\NotFoundHttpException;
use devskyfly\yiiModuleIitUc\components\RatesManager;
use devskyfly\yiiModuleIitUc\models\site\Site;
use devskyfly\yiiModuleIitUc\models\siteCalcGroup\SiteCalcGroup;
use devskyfly\php56\types\Arr;
use devskyfly\yiiModuleIitUc\models\siteCalcGroup\SiteCalcGroupToSiteBinder;
use devskyfly\php56\types\Vrbl;
use devskyfly\yiiModuleIitUc\components\SitesManager;
use devskyfly\php56\types\Nmbr;
use devskyfly\yiiModuleIitUc\components\StocksManager;

/**
 * Rest api class
 */
class SitesCalcController extends CommonController
{

    /**
     * Return sites and add information about related rate and its stock
     * 
     * GET
     * 
     * Return:
     * [
     *  [
     *      id: number,
     *      name: string,
     *      slx_id: string,
     *      stock: number,
     *      calc_name: string,
     *      calc_sort: string,
     *      url: string,
     *      calc_group: number,
     *  ],...
     * ]
     */
    public function actionIndex()
    {
        try {
                $result=[];
                $sites = Site::find()
                ->where(['active' => 'Y','flag_show_in_calc' => 'Y'])
                ->orderBy([
                    
                    'calc_sort'=>SORT_ASC, 
                    'name'=>SORT_ASC,
                    ])
                ->all();
                
                foreach ($sites as $site) {
                    $rate = SitesManager::getCheepRate($site);
                    
                    if(Vrbl::isNull($rate)){
                        continue;
                    }
                   
                    $rootRate = RatesManager::getRootRate($rate);
                    $stock = StocksManager::getStockByRate($rootRate);
                    
                    $groupIds = SiteCalcGroupToSiteBinder::getMasterIds($site->id);
                    
                    if (Vrbl::isEmpty($groupIds)
                    ||(Arr::getSize($groupIds)>1)) {
                        continue;
                    }

                    $result[] = [
                        "id" => $site->id,
                        "name" => $site->name,
                        "slx_id" => $rate->slx_id,
                        "stock" => $stock->stock,
                        "calc_name" =>!Vrbl::isEmpty($site->calc_name)?$site->calc_name:$site->name,
                        "calc_sort" =>Nmbr::toInteger($site->calc_sort),
                        "url" =>$site->url,
                        "calc_group" => $groupIds,
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

    /**
     * Return sites calc groups
     * 
     * GET
     * 
     * Return:
     * [
     *  [
     *      id: number,
     *      name: string,
     *      calc_sort: string
     *  ],...
     * ]
     */
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
