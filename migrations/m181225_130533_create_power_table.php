<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;

/**
 * Handles the creation of table `power`.
 */
class m181225_130533_create_power_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('iit_uc_power', $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_power');
    }
}
