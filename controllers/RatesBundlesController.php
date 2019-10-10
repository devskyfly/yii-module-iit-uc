<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\Binder;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\ItemSelector;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundleFilter;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundleSection;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundleToExtendedRatesBinder;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundleToAdditionalRatesBinder;
use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundleToRatesBinder;
use devskyfly\yiiModuleIitUc\models\stock\Stock;

class RatesBundlesController extends AbstractContentPanelController
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionItem()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, товместо названия класса можно передать null
        return RateBundleSection::class;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityItem()
     */
    public static function entityCls()
    {
        return RateBundle::class;
    }
    
    /**
     *
     * @return string
     */
    public static function entityFilterCls()
    {
        return RateBundleFilter::class;
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
            $rates__binder_cls = RateBundleToRatesBinder::class;
            $additional_rates__binder_cls = RateBundleToAdditionalRatesBinder::class;
            
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
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                        .'</div>'
                        .'<div class="col-xs-2">'
                        .$form->field($item,'flag_for_crypto_pro')
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                        .'</div>'
                        .'<div class="col-xs-2">'
                        .$form->field($item,'flag_is_terminated')
                        ->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                        .'</div>'
                    .'</div>'
                    .$form->field($item,'price')
                    .$form->field($item,'sale')
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
                        "property"=>"_parent_rate__id"
                    ])
                ],

                [
                    "label"=>"calc",
                    "content"=>
                    $form->field($item,'calc_name')->textarea(["rows"=>5])
                ],
            
                [
                    "label"=>"Тарифы",
                    "content"=>
                    Binder::widget([
                        "label"=>"Видимые тарифы",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$rates__binder_cls
                    ])
                    .Binder::widget([
                        "label"=>"Дополнительные тарифы",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$additional_rates__binder_cls
                    ])
                    
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
        return "Бандлы тарифов";
    }
}

