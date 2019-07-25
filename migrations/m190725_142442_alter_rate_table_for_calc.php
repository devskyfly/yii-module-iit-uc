<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190725_142442_alter_rate_table_for_calc
 */
class m190725_142442_alter_rate_table_for_calc extends Migration
{
    public $table = "iit_uc_rate";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
        $this->addColumn($this->table, 'calc_name', Schema::TYPE_STRING);
        $this->addColumn($this->table, 'calc_sort', Schema::TYPE_INTEGER);
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

    
}
