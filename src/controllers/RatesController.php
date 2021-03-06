<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\Binder;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\ItemSelector;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\rate\RateFilter;
use devskyfly\yiiModuleIitUc\models\rate\RateSection;
use devskyfly\yiiModuleIitUc\models\rate\RateToExcludedServiceBinder;
use devskyfly\yiiModuleIitUc\models\rate\RateToPowerPackageBinder;
use devskyfly\yiiModuleIitUc\models\rate\RateToSiteBinder;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\widgets\SlavePowersList;
use devskyfly\yiiModuleIitUc\widgets\SlaveSitesList;
use devskyfly\yiiModuleIitUc\models\rate\RateToRecomendedServiceBinder;

class RatesController extends AbstractContentPanelController
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionItem()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, товместо названия класса можно передать null
        return RateSection::class;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityItem()
     */
    public static function entityCls()
    {
        return Rate::class;
    }
    
    /**
     *
     * @return string
     */
    public static function entityFilterCls()
    {
        return RateFilter::class;
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
            $rate_to_site_binder_cls=RateToSiteBinder::class;
            $rate_to_power_package_binder_cls = RateToPowerPackageBinder::class;
            //$rate_to_included_service_binder_cls=RateToIncludedService::class;
            $rate_to_recomended_service_binder_cls = RateToRecomendedServiceBinder::class;
            $rate_to_excluded_service_binder_cls = RateToExcludedServiceBinder::class;
            
            return [
                [
                    "label"=>"main",
                    "content"=>
                    $form->field($item,'name')
                    .ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>$item::getSectionCls(),
                        "property"=>"_section__id"
                    ])
                    
                    .$form->field($item,'create_date_time')
                    .$form->field($item,'change_date_time')
                    .$form->field($item,'sort')
                    .'<div class="row">'
                        .'<div class="col-xs-2">'
                        .$form->field($item,'active')
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                        .'</div>'
                        .'<div class="col-xs-2">'
                        .$form->field($item,'flag_for_license')
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->flag_for_license=='Y'?true:false])
                        .'</div>'
                        .'<div class="col-xs-2">'
                        .$form->field($item,'flag_for_crypto_pro')
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->flag_for_crypto_pro=='Y'?true:false])
                        .'</div>'
                        .'<div class="col-xs-2">'
                        .$form->field($item,'flag_is_terminated')
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->flag_is_terminated=='Y'?true:false])
                        .'</div>'
                    .'</div>'
                    .$form->field($item,'price')
                    .$form->field($item,'slx_id')
                    .$form->field($item,'comment')->textarea(["rows"=>5])
                    .$form->field($item,'tooltip')->textarea(["rows"=>5])
                    .$form->field($item,'client_type')

                ],
                [
                    "label"=>"binds",
                    "content"=>
                    ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>Stock::class,
                        "property"=>"_stock__id"
                    ])
                    .ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>Rate::class,
                        "property"=>"__id"
                    ])
                ],
                [
                    "label"=>"calc",
                    "content"=>
                    $form->field($item,'flag_show_in_calc')
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false]) 
                    .$form->field($item,'calc_name')->textarea(["rows"=>5])
                    .$form->field($item,'calc_sort')
                ],
                [
                    "label"=>"sites",
                    "content"=>
                    Binder::widget([
                        "label"=>"Площадки",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$rate_to_site_binder_cls
                    ])
                ],
                [
                    "label"=>"powers and services",
                    "content"=>
                    Binder::widget([
                        "label"=>"Полномочия",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$rate_to_power_package_binder_cls
                    ])
                    /* .Binder::widget([
                        "label"=>"Включенные услуги",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$rate_to_included_service_binder_cls
                    ]) */
                    .Binder::widget([
                        "label"=>"Рекомендуемые доп. услуги",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$rate_to_recomended_service_binder_cls
                    ])
                    .Binder::widget([
                        "label"=>"Исключенные доп. услуги",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$rate_to_excluded_service_binder_cls
                    ])
                ],
                
                [
                    "label"=>"tools",
                    "content"=>
                    SlaveSitesList::widget(['model'=>$item])
                    .SlavePowersList::widget(['model'=>$item])
                ],
                
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
        return function($form,$item)
        {
            
            return [
                [
                    "label"=>"main",
                    "content"=>
                    $form->field($item,'name')
                    .ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>Obj::getClassName($item),
                        "property"=>"__id"
                    ])
                    .$form->field($item,'create_date_time')
                    .$form->field($item,'change_date_time')
                    .$form->field($item,'active')->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                    
                ]
            ];
        };
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::itemLabel()
     */
    public function itemLabel()
    {
        return "Тарифы";
    }
}

