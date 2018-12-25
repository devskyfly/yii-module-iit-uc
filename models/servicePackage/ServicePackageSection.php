<?php
namespace devskyfly\yiiModuleIitUc\models\service;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class ServicePackageSection extends AbstractSection
{
    protected static function entityCls()
    {
        return ServicePackage::class;
    } 
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "iit-uc/services-packages/section-select-list";
    }
}