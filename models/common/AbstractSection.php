<?php
namespace devskyfly\yiiModuleIitUc\models\common;


use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractSection as Section;

abstract class AbstractSection extends Section
{
    public static function tableName()
    {
        return 'iit_uc_section';
    }
}