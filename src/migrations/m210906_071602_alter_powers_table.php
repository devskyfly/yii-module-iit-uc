<?php

use devskyfly\yiiModuleIitUc\models\power\Power;
use yii\db\Migration;

/**
 * Class m210906_071602_alter_powers_table
 */
class m210906_071602_alter_powers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "ALTER TABLE ".Power::tableName()." ADD COLUMN client_type CHAR(255);";
        $this->execute($sql);

        $powers = Power::find()->where(['>=','id',0])->all();
        foreach ($powers as $power) {
            $power->client_type = '["UL","IP","FIZ"]';
            $power->update(false);
        }

        $oids = ["1.2.643.5.1.24.2.27", "1.2.643.5.1.24.2.1.3", "1.2.643.5.1.24.2.1.3.1"];

        foreach ($oids as $oid) {
            $power = Power::findOne(["oid" => $oid]);
            $power->oid = $oid;
            $power->client_type = '["FIZ"]';
            $power->update(false);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Power::tableName(), 'client_type');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210906_071602_alter_powers_table cannot be reverted.\n";

        return false;
    }
    */
}
