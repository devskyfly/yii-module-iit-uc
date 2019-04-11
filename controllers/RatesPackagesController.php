<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\Binder;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\ItemSelector;
use devskyfly\yiiModuleIitUc\models\powerPackage\PowerPackageSection;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use devskyfly\yiiModuleIitUc\models\ratePackage\RatePackage;
use devskyfly\yiiModuleIitUc\models\ratePackage\RatePackageFilter;
use devskyfly\yiiModuleIitUc\models\ratePackage\RatePackageToRateBinder;

class RatesPackagesController extends AbstractContentPanelController
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionItem()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, товместо названия класса можно передать null
        return PowerPackageSection::class;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityItem()
     */
    public static function entityCls()
    {
        return RatePackage::class;
    }
    
    
    /**
     *
     * @return string
     */
    public static function entityFilterCls()
    {
        return RatePackageFilter::class;
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
            $rate_package_to_power_binder_cls=RatePackageToRateBinder::class;
            
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
                    .ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>Rate::class,
                        "property"=>"_parent_rate__id"
                    ])
                    .$form->field($item,'create_date_time')
                    .$form->field($item,'change_date_time')
                    .$form->field($item,'active')->checkbox(['value'=>'Y','uncheck'=>'N','checked'=>$item->active=='Y'?true:false])
                    .$form->field($item,'select_type')->dropDownList(['MULTI'=>'MULTI','MONO'=>'MONO'])
                ],
                [
                    "label"=>"binds",
                    "content"=>
                    Binder::widget([
                        "label"=>"Тарифы",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$rate_package_to_power_binder_cls
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
        return "Пакеты тарифов";
    }
}

