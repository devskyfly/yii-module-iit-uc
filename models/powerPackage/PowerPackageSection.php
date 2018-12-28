<?php
namespace devskyfly\yiiModuleIitUc\models\powerPackage;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class PowerPackageSection extends AbstractSection
{
    protected static function entityCls()
    {
        return PowerPackage::class;
    } 
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/power-packages/section-select-list";
    }
}