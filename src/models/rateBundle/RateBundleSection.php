<?php
namespace devskyfly\yiiModuleIitUc\models\rateBundle;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class RateBundleSection extends AbstractSection
{
    protected static function entityCls()
    {
        return RateBundle::class;
    } 
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/rates-bundles/section-select-list";
    }
}