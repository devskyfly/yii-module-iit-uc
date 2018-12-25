<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;


class Rate extends AbstractEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return RateSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "iit-uc/rates/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_rate';
    }
}