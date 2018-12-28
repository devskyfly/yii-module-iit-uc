<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `power_package`.
 */
class m181228_105929_create_power_package_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fileds=ArrayHelper::merge($this->getFieldsDefinition(), [
            "select_type"=>"ENUM('MONO','MULTI') NOT NULL",
        ]);
        
        $this->createTable('iit_uc_power_package', $fileds);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_power_package');
    }
}
