<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;

/**
 * Class m191219_075344_create_table_site_grups
 */
class m191219_075344_create_table_site_group extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("iit_uc_site_group", $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("iit_uc_site_group");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191219_075344_create_table_site_grups cannot be reverted.\n";

        return false;
    }
    */
}
