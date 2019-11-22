<?php
namespace devskyfly\yiiModuleIitUc\models\common;

use devskyfly\yiiModuleAdminPanel\models\contentPanel\AbstractBinder as Binder;
use devskyfly\yiiModuleIitUc\traits\DbTrait;

abstract class AbstractBinder extends Binder
{
    use DbTrait;
    
    public static function tableName()
    {
        return 'iit_uc_binder';
    }
}