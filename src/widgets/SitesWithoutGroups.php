<?php
namespace devskyfly\yiiModuleIitUc\widgets;

use yii\base\Widget;
use devskyfly\yiiModuleIitUc\models\siteCalcGroup\SiteCalcGroupToSiteBinder;
use devskyfly\yiiModuleIitUc\models\site\Site;

class SitesWithoutGroups extends Widget
{
    protected $list=[];
    
    public function init()
    {
        parent::init();

        $sites = $this->getAllSites();
        $binded_sites = array_unique($this->getBindedSites());
        $diff = array_unique(array_diff($sites, $binded_sites));

        foreach ($diff as $id) {
            $site = Site::find()->where(['active'=>'Y','id'=>$id])->one();
            if ($site) {
                $this->list[] = $site;
            }
        }
    }
    

    protected function getAllSites()
    {
        $sites = Site::find()
        ->where(['active'=>'Y'])
        ->asArray()
        ->all();
        return array_column($sites, 'id');
    }

    /*protected function getDisabledSites()
    {
        $sites = Site::find()
        ->where(['flag_show_in_calc' => 'N', 'active'=>'Y'])
        ->asArray()
        ->all();

        return array_column($sites, 'id');
    }*/

    protected function getBindedSites()
    {
        return SiteCalcGroupToSiteBinder::getAllSlaveIds();
    }

    public function run()
    {
        $list=$this->list;
        return $this->render('sites-without-groups', compact("list"));
    }
}