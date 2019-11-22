<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190726_133929_alter_site
 */
class m190726_133929_alter_site extends Migration
{
    public $table = "iit_uc_site";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->table, 'calc_sort', Schema::TYPE_INTEGER);
        $this->addColumn($this->table, 'calc_name', Schema::TYPE_STRING);
        $sql="ALTER TABLE {$this->table} ADD COLUMN flag_show_in_calc ENUM('Y','N') DEFAULT 'N';";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->table, 'calc_name');
        $this->dropColumn($this->table, 'calc_sort');
        $this->dropColumn($this->table, 'flag_show_in_calc');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190726_133929_alter_site cannot be reverted.\n";

        return false;
    }
    */
}
