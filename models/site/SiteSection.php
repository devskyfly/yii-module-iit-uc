<?php
namespace devskyfly\yiiModuleIitUc\models\site;

use devskyfly\yiiModuleIitUc\models\common\AbstractSection;

class SiteSection extends AbstractSection
{
    protected static function entityCls()
    {
        return Site::class;
    } 
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "iit-uc/sites/section-select-list";
    }
}