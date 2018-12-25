<?php

use yii\db\Migration;
use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;

/**
 * Handles the creation of table `rate`.
 */
class m181225_130400_create_rate_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('iit_uc_rate', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_rate');
    }
}
