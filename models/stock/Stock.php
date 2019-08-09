<?php
namespace devskyfly\yiiModuleIitUc\models\stock;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;

/**
 * 
 * @author devskyfly
 * @property integer $stock
 */
class Stock extends AbstractEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    protected static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return StockSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    
    public static function selectListRoute()
    {
        return "/iit-uc/stocks/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_stock';
    }
    
    public function rules()
    {
        $old_rules=parent::rules();
        
        $new_rules=[
            [["stock"],"required"],
            [["stock"],"string"]
        ];
        
        return ArrayHelper::merge($old_rules, $new_rules);
    }

    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::binders()
     */
    public function binders()
    {
        return [
            'StockToServicePackageBinder'=>StockToServicePackageBinder::class,
            'StockToCheckedServiceBinder'=>StockToCheckedServiceBinder::class
        ];
    }

    public function __toString()
    {
        return "".$this->id;
    }
}