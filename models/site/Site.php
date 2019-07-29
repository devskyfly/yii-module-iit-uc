<?php
namespace devskyfly\yiiModuleIitUc\models\site;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;

/**
 * 
 * @author devskyfly
 * @property string $url
 * @property string $comment
 * @property string $tooltip
 * @property string $flag_show_in_calc
 * @property string $calc_sort
 * @property string $calc_name
 */
class Site extends AbstractEntity
{
    /**
     *
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleContentPanel\models\contentPanel\AbstractSection::section()
     */
    protected static function sectionCls()
    {
        //Если иерархичность не требуется, то вместо названия класса можно передать null
        return SiteSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/sites/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_site';
    }
    
    public function rules()
    {
        $old_rules=parent::rules();
        
        $new_rules=[
            [
                [
                "url",
                "comment",
                "tooltip",
                "flag_show_in_calc",
                "calc_name"
                ],"string"],
            [
                [
                    "calc_sort",
                ],"number"]
        ];
        
        return ArrayHelper::merge($old_rules, $new_rules);
    }

    public function __toString()
    {
        return $this->id;
    }
}