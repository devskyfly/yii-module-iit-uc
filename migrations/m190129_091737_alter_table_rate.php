<?php

use yii\db\Migration;

/**
 * Class m190129_091737_alter_table_rate
 */
class m190129_091737_alter_table_rate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="ALTER TABLE iit_uc_rate ADD COLUMN flag_for_license ENUM('Y','N') DEFAULT 'N';";
        $sql.="ALTER TABLE iit_uc_rate ADD COLUMN flag_for_crypto_pro ENUM('Y','N') DEFAULT 'N';";
        $sql.="ALTER TABLE iit_uc_rate ADD COLUMN flag_is_terminated ENUM('Y','N') DEFAULT 'N';";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190129_091737_alter_table_rate cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190129_091737_alter_table_rate cannot be reverted.\n";

        return false;
    }
    */
}
