<?php
namespace devskyfly\yiiModuleIitUc\models\service;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;

class ServicePackage extends AbstractEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return ServicePackageSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "iit-uc/services-packages/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_service_package';
    }
}