<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\Binder;
use devskyfly\yiiModuleAdminPanel\widgets\contentPanel\ItemSelector;
use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\models\stock\StockFilter;
use devskyfly\yiiModuleIitUc\models\stock\StockSection;
use devskyfly\yiiModuleIitUc\models\stock\StockToCheckedServiceBinder;
use devskyfly\yiiModuleIitUc\models\stock\StockToServicePackageBinder;

class StocksController extends AbstractContentPanelController
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::sectionItem()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, товместо названия класса можно передать null
        return StockSection::class;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\controllers\contentPanel\AbstractContentPanelController::entityItem()
     */
    public static function entityCls()
    {
        return Stock::class;
    }
    
    /**
     *
     * @return string
     */
    public static function entityFilterCls()
    {
        return StockFilter::class;
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
            $stock_to_checked_service_binder_cls=StockToCheckedServiceBinder::class;
            $stock_to_service_package_binder_cls=StockToServicePackageBinder::class;
            
            return [
                [
                    "label"=>"main",
                    "content"=>
                    $form->field($item,'name')
                    .ItemSelector::widget([
                        "form"=>$form,
                        "master_item"=>$item,
                        "slave_item_cls"=>$item::sectionCls(),
                        "property"=>"_section__id"
                    ])
                    .$form->field($item,'create_date_time')
                    .$form->field($item,'change_date_time')
                    .$form->field($item,'active')->checkbox(['value'=>'Y','uncheckValue'=>'N','checked'=>$item->active=='Y'?true:false])
                    .$form->field($item,'stock')
                    .$form->field($item,'client_type')
                ],
                [
                    "label"=>"binds",
                    "content"=>
                    Binder::widget([
                        "label"=>"Пакеты доп. услуг",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$stock_to_service_package_binder_cls
                    ])
                    .Binder::widget([
                        "label"=>"Отмеченные доп. услуги",
                        "form"=>$form,
                        "master_item"=>$item,
                        "binder_cls"=>$stock_to_checked_service_binder_cls
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
                    .$form->field($item,'active')->checkbox(['value'=>'Y','uncheckValue'=>'N','checked'=>$item->active=='Y'?true:false])
                    
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
        return "Услуги";
    }
}

