<?php
namespace devskyfly\yiiModuleIitUc\models\power;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class PowerSection extends AbstractSection
{
    protected static function entityCls()
    {
        return Power::class;
    } 
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "iit-uc/powers/section-select-list";
    }
}