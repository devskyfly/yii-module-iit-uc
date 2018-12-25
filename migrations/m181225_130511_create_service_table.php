<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m181225_130511_create_service_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('iit_uc_service', $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_service');
    }
}
