<?php
namespace devskyfly\yiiModuleIitUc\models\service;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;

/**
 * 
 * @author devskyfly
 * @property string $price
 * @property string $slx_id
 * @property string $comment
 * @property string $tooltip
 */
class Service extends AbstractEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    public static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return ServiceSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/services/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_service';
    }
    
    public function rules()
    {
        $old_rules=parent::rules();
        $new_rules=[
            //[["price","slx_id"],"required"],
            [["price"],"required"],
            [["price","slx_id","comment","tooltip"],"string"]
        ];
        return ArrayHelper::merge($old_rules, $new_rules);
    }
    
    public function __toString()
    {
        return $this->id;
    }
}