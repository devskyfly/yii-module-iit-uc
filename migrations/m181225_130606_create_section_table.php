<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\SectionMigrationHelper;
use yii\db\Migration;

/**
 * Handles the creation of table `section`.
 */
class m181225_130606_create_section_table extends SectionMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('iit_uc_section', $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_section');
    }
}
