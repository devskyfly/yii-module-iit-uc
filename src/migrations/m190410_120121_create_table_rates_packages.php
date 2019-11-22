<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Class m190410_120121_create_table_rates_packages
 */
class m190410_120121_create_table_rates_packages extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fileds=ArrayHelper::merge($this->getFieldsDefinition(), [
            "_parent_rate__id"=> "INT(11)",
            "select_type"=>"ENUM('MONO','MULTI') NOT NULL",
        ]);
        
        $this->createTable('iit_uc_rate_package', $fileds);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_rate_package');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190410_120121_create_table_rates_packages cannot be reverted.\n";

        return false;
    }
    */
}
