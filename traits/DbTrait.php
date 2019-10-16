<?php
namespace devskyfly\yiiModuleIitUc\traits;

use devskyfly\php56\types\Obj;
use devskyfly\yiiModuleIitUc\Module;
use yii\db\Connection;

trait DbTrait
{
    public static function getDb()
    {
        $module = Module::getInstance();
        if (Obj::isA($module->db, Connection::className())) {
            return $module->db;
        } else {
            return parent::getDb();
        }
    }
}
