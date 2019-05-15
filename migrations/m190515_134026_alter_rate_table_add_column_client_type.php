<?php

use yii\db\Migration;

/**
 * Class m190515_134026_alter_rate_table_add_column_client_type
 */
class m190515_134026_alter_rate_table_add_column_client_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="ALTER TABLE iit_uc_rate ADD COLUMN client_type TEXT;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190515_134026_alter_rate_table_add_column_client_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190515_134026_alter_rate_table_add_column_client_type cannot be reverted.\n";

        return false;
    }
    */
}
