<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;

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
        $this->createTable('iit_uc_service_package', $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_service_package');
    }
}
