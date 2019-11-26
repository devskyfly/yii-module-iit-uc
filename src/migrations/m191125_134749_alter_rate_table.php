<?php

use devskyfly\yiiModuleIitUc\models\rateBundle\RateBundle;
use yii\db\Migration;

/**
 * Class m191125_134749_alter_rate_table
 */
class m191125_134749_alter_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "ALTER TABLE ".RateBundle::tableName()." ADD COLUMN flag_for_iit_offices ENUM('Y','N') DEFAULT 'N';";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(RateBundle::tableName(), "flag_for_iit_offices");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191125_134749_alter_rate_table cannot be reverted.\n";

        return false;
    }
    */
}
