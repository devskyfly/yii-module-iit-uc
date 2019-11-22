<?php

use yii\db\Migration;
use devskyfly\yiiModuleIitUc\models\service\Service;

/**
 * Class m190530_123324_alter_service_table
 */
class m190530_123324_alter_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "ALTER TABLE ".Service::tableName()." ADD COLUMN flag_is_fast_release ENUM('Y','N') DEFAULT 'N';";
        $sql .= "ALTER TABLE ".Service::tableName()." ADD COLUMN flag_for_license ENUM('Y','N') DEFAULT 'N';";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190530_123324_alter_service_table cannot be reverted.\n";
        $this->dropColumn(Service::tableName(),'flag_is_fast_release');
        $this->dropColumn(Service::tableName(),'flag_for_license');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190530_123324_alter_service_table cannot be reverted.\n";

        return false;
    }
    */
}
