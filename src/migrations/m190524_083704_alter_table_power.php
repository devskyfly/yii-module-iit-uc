<?php

use yii\db\Migration;

/**
 * Class m190524_083704_alter_table_power
 */
class m190524_083704_alter_table_power extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="ALTER TABLE iit_uc_power MODIFY COLUMN oid TEXT;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190524_083704_alter_table_power cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190524_083704_alter_table_power cannot be reverted.\n";

        return false;
    }
    */
}
