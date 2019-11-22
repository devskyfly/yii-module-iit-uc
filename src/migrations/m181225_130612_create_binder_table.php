<?php

use yii\db\Migration;
use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\BinderMigrationHelper;

/**
 * Handles the creation of table `binder`.
 */
class m181225_130612_create_binder_table extends BinderMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('iit_uc_binder', $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_binder');
    }
}
