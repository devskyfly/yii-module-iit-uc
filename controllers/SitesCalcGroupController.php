<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\Binder;
use devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController;
use devskyfly\yiiModuleIitUc\models\siteCalcGroup\SiteCalcGroup;
use devskyfly\yiiModuleIitUc\models\siteCalcGroup\SiteCalcGroupFilter;
use devskyfly\yiiModuleIitUc\models\siteCalcGroup\SiteCalcGroupToSiteBinder;

class SitesCalcGroupController extends AbstractContentPanelController
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionItem()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, товместо названия класса можно передать null
        return null;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityItem()
     */
    public static function entityCls()
    {
        return SiteCalcGroup::class;
    }
    
    /**
     * 
     * @return string
     */
    public static function entityFilterCls()
    {
        return SiteCalcGroupFilter::class;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityEditorViews()
     */
    public function entityEditorViews()
    {
        return function($form,$item)
        {
            $site_calc_group_to_rate_binder = SiteCalcGroupToSiteBinder::class;
            return [
                [
                    "label"=>"main",
                    "content"=>
                    $form->field($item,'name')
                    .$form->field($item,'create_date_time')
                    .$form->field($item,'change_date_time')
                    .$form->field($item,'sort')
                    .$form->field($item,'active')->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                    .Binder::widget([
                        "label"=>"Площадки",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$site_calc_group_to_rate_binder
                    ])
                ]
            ];
        };
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionEditorItems()
     */
    public function sectionEditorViews()
    {
        return null;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::itemLabel()
     */
    public function itemLabel()
    {
        return "Группы площадок для калькулятора";
    }
}

