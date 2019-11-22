<?php
namespace devskyfly\yiiModuleIitUc\models\power;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use devskyfly\yiiModuleIitUc\traits\DbTrait;
use yii\helpers\ArrayHelper;

/**
 * 
 * @author devskyfly
 * @property string oid
 * @property string detail_text
 */
class Power extends AbstractEntity
{
    use DbTrait;
    
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    protected static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return PowerSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/powers/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_power';
    }
    
    public function rules()
    {
        $old_rules=parent::rules();
        
        $new_rules=[
            //[[],"required"],
            [['oid','detail_text'],"string"]
        ];
        
        return ArrayHelper::merge($old_rules, $new_rules);
    }
    
    public function __toString()
    {
        return "".$this->id;
    }
}