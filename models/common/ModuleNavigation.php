<?php
namespace devskyfly\yiiModuleIitUc\models\common;

use devskyfly\yiiModuleAdminPanel\models\common\AbstractModuleNavigation;

class ModuleNavigation extends AbstractModuleNavigation
{
    protected function moduleRoute()
    {
        return "/iit-uc/";
    }

    protected function moduleList()
    {
        return
        [
            ['name'=>'Услуги','route'=>'/iit-uc/stocks'],
            ['name'=>'Тарифы','route'=>'/iit-uc/rates'],
            ['name'=>'Пакеты тарифов','route'=>'/iit-uc/rates-packages'],
            ['name'=>'Площадки','route'=>'/iit-uc/sites'],
            ['name'=>'Доп. услуги','route'=>'/iit-uc/services'],
            ['name'=>'Пакеты доп. услуги','route'=>'/iit-uc/services-packages'],
            ['name'=>'Полномочия','route'=>'/iit-uc/powers'],
            ['name'=>'Пакеты полномочий','route'=>'/iit-uc/powers-packages'],
            ['name'=>'Группы тарифов для калькулятора','route'=>'/iit-uc/rates-calc-group'],
            ['name'=>'Группы сайтов для калькулятора','route'=>'/iit-uc/sites-calc-group']
        ];
    }

    protected function moduleName()
    {
        return 'iit-uc';
    }

}