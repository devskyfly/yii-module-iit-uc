<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class RateSection extends AbstractSection
{
    protected static function entityCls()
    {
        return Rate::class;
    } 
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "iit-uc/rates/section-select-list";
    }
}