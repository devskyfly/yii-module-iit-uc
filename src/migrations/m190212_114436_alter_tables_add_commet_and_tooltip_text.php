<?php

use yii\db\Migration;

/**
 * Class m190212_114436_alter_tables_add_commet_and_tooltip_text
 */
class m190212_114436_alter_tables_add_commet_and_tooltip_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="ALTER TABLE iit_uc_rate ADD COLUMN comment TEXT;";
        $sql.="ALTER TABLE iit_uc_site ADD COLUMN comment TEXT;";
        $sql.="ALTER TABLE iit_uc_service ADD COLUMN comment TEXT;";
        
        $sql.="ALTER TABLE iit_uc_rate ADD COLUMN tooltip TEXT;";
        $sql.="ALTER TABLE iit_uc_site ADD COLUMN tooltip TEXT;";
        $sql.="ALTER TABLE iit_uc_service ADD COLUMN tooltip TEXT;";

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190212_114436_alter_tables_add_commet_and_tooltip_text cannot be reverted.\n";

        return false;
    }

    
}
