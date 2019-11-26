<?php
namespace devskyfly\yiiModuleIitUc\models\rate;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractEntity;
use yii\helpers\ArrayHelper;
use devskyfly\php56\types\Str;
use devskyfly\yiiModuleIitUc\traits\DbTrait;

/**
 * 
 * @author devskyfly
 * @property integer $__id
 * @property string $price
 * @property integer $_stock__id
 * @property string $slx_id
 * @property string $flag_for_license
 * @property string $flag_for_crypto_pro
 * @property string $flag_is_terminated
 * @property string $comment
 * @property string $tooltip
 * @property string $client_type
 * @property string $calc_name
 * @property string $cacl_sort
 * @property string $flag_show_in_calc
 */
class Rate extends AbstractEntity
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
        return RateSection::class;
    }
    
    /**
     * {@inheritdoc}
     * @see devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::selectListRoute()
     * Здесь прописывается роут к списку выбора
     */
    public static function selectListRoute()
    {
        return "/iit-uc/rates/entity-select-list";
    }
    
    public static function tableName()
    {
        return 'iit_uc_rate';
    }
    
    public function rules()
    {
        $old_rules=parent::rules();
        $new_rules=[
            [["price","slx_id"],"required"],
            [["price", 
            "slx_id", 
            "flag_for_license", 
            "flag_for_crypto_pro", 
            "flag_is_terminated", 
            "comment", 
            "tooltip", 
            "client_type",
            "calc_name",
            "flag_show_in_calc"], "string"],
            [["__id","_stock__id","calc_sort"],'number']
        ];
        return ArrayHelper::merge($old_rules, $new_rules);
    }
    
    public function attributeLabels()
    {
        $labels=parent::attributeLabels();
        $labels['__id']="Parent rate";
        $labels['_stock__id']="Parent stock";
        return $labels;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractItem::binders()
     */
    public function binders(){
        return [
            'RateToPowerPackageBinder'=>RateToPowerPackageBinder::class,
            'RateToSiteBinder'=>RateToSiteBinder::class,
            //'RateToIncludedService'=>RateToIncludedService::class,
            'RateToExcludedServiceBinder'=>RateToExcludedServiceBinder::class,
            'RateToRecomendedServiceBinder'=>RateToRecomendedServiceBinder::class,
        ];
    }

    public function __toString()
    {
        return $this->slx_id;
    }

    public function getBySlxId($slxId)
    {
        if(!Str::isString($slxId)){
            throw new \InvalidArgumentException('Param $slxId is not string type.');
        }
        return static::find()->where(['active'=>'Y', 'slx_id'=>$slxId])->one();
    }
}