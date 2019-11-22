<?php

use yii\db\Migration;

/**
 * Class m190325_131534_alter_rate_table
 */
class m190325_131534_alter_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    { 
        $sql="ALTER TABLE iit_uc_rate MODIFY COLUMN flag_for_license ENUM('Y','N') DEFAULT 'N' NOT NULL;";
        $sql.="ALTER TABLE iit_uc_rate MODIFY COLUMN flag_for_crypto_pro ENUM('Y','N') DEFAULT 'N'  NOT NULL;";
        $sql.="ALTER TABLE iit_uc_rate MODIFY COLUMN flag_is_terminated ENUM('Y','N') DEFAULT 'N'  NOT NULL;";
        
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190325_131534_alter_rate_table cannot be reverted.\n";

        return false;
    }
    */
}
