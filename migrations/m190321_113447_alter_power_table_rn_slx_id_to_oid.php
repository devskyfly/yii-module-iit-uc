<?php

use yii\db\Migration;

/**
 * Class m190321_113447_alter_power_table_rn_slx_id_to_oid
 */
class m190321_113447_alter_power_table_rn_slx_id_to_oid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('iit_uc_power', 'slx_id', 'oid');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('iit_uc_power', 'oid', 'slx_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190321_113447_alter_power_table_rn_slx_id_to_oid cannot be reverted.\n";

        return false;
    }
    */
}
