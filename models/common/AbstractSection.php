<?php
namespace devskyfly\yiiModuleIitUc\models\common;


use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection as Section;
use devskyfly\yiiModuleIitUc\traits\DbTrait;

abstract class AbstractSection extends Section
{
    use DbTrait;
    
    public static function tableName()
    {
        return 'iit_uc_section';
    }
}