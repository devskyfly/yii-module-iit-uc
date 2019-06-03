<?php

use yii\db\Migration;
use devskyfly\yiiModuleIitUc\models\service\Service;

/**
 * Class m190603_134046_update_service_table
 */
class m190603_134046_update_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $services = Service::find()->where([])->all();
        foreach($services as $service){
            $service->sort=500;
            $service->saveLikeItem();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190603_134046_update_service_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190603_134046_update_service_table cannot be reverted.\n";

        return false;
    }
    */
}
