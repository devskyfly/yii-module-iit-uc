<?php
namespace devskyfly\yiiModuleIitUc\models\stock;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class StockSection extends AbstractSection
{
    protected static function entityCls()
    {
        return Stock::class;
    } 
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/stocks/section-select-list";
    }
}