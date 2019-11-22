<?php

use yii\db\Migration;

/**
 * Class m190515_092020_alter_table_service_package
 */
class m190515_092020_alter_table_service_package extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="ALTER TABLE iit_uc_service_package MODIFY COLUMN select_type ENUM('MONO','MULTI','MULTIONE');";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190515_092020_alter_table_service_package cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_092020_alter_table_service_package cannot be reverted.\n";

        return false;
    }
    */
}
