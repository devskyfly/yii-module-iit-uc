<?php
namespace devskyfly\yiiModuleIitUc\models\ratePackage;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class RatePackageSection extends AbstractSection
{
    protected static function entityCls()
    {
        return RatePackage::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/rate-packages/section-select-list";
    }
}