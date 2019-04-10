<?php
namespace devskyfly\yiiModuleIitUc\models\ratePackage;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;

/**
 *
 * @author devskyfly
 * @property string $select_type
 */
class RatePackage extends AbstractEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    protected static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return RatePackageSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/powers-packages/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_rate_package';
    }
    
    public function rules()
    {
        $old_rules=parent::rules();
        
        $new_rules=[
            [["select_type"],"required"],
            [["_parent_rate__id"],"number"],
            [["select_type"],"string"]
        ];
        
        return ArrayHelper::merge($old_rules, $new_rules);
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::binders()
     */
    public function binders()
    {
        return [
            'RatePackageToRateBinder'=>RatePackageToRateBinder::class
        ];
    }
}