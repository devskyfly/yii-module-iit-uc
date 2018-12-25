<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;

/**
 * Handles the creation of table `site`.
 */
class m181225_130459_create_site_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('iit_uc_site', $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_site');
    }
}
