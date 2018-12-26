<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `service_package`.
 */
class m181225_130555_create_service_package_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fileds=ArrayHelper::merge($this->getFieldsDefinition(), [
            "select_type"=>"ENUM('MONO','MULTI') NOT NULL",
        ]);
        
        $this->createTable('iit_uc_service_package', $fileds);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_service_package');
    }
}
