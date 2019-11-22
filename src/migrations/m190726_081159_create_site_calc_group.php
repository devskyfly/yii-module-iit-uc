<?php

use yii\db\Migration;
use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;

/**
 * Class m190726_081159_create_site_calc_group
 */
class m190726_081159_create_site_calc_group extends EntityMigrationHelper
{
    public $table = "iit_uc_site_calc_group";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fields = $this->getFieldsDefinition();
        $this->createTable($this->table, $fields);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190726_081159_create_site_calc_group cannot be reverted.\n";

        return false;
    }
    */
}
