<?php
namespace devskyfly\yiiModuleIitUc\models\powerPackage;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;

/**
 * 
 * @author devskyfly
 * @property string $select_type
 */
class PowerPackage extends AbstractEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return PowerPackageSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/power-packages/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_power_package';
    }
    
    public function rules()
    {
        $old_rules=parent::rules();
        
        $new_rules=[
            [["select_type"],"required"],
            [["select_type"],"string"]
        ];
        
        return ArrayHelper::merge($old_rules, $new_rules);
    }
}