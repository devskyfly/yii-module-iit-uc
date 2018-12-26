<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `power`.
 */
class m181225_130533_create_power_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fileds=ArrayHelper::merge($this->getFieldsDefinition(), [
            "slx_id"=>$this->string(20)
        ]);
        
        $this->createTable('iit_uc_power', $fileds);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_power');
    }
}
