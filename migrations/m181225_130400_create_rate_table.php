<?php

use yii\db\Migration;
use yii\helpers\ArrayHelper;
use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;

/**
 * Handles the creation of table `rate`.
 */
class m181225_130400_create_rate_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $fileds=ArrayHelper::merge($this->getFieldsDefinition(), [
            "__id"=>$this->integer(11),
            "price"=>$this->string(11),
            "_stock__id"=>$this->integer(11),
            "slx_id"=>$this->string(20),
        ]);
        
        $this->createTable('iit_uc_rate', $fileds);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_rate');
    }
}
