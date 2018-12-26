<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `stock`.
 */
class m181225_131624_create_stock_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fileds=ArrayHelper::merge($this->getFieldsDefinition(), [
            "stock"=>$this->integer(11),
            "client_type"=>$this->string(255),
        ]);
        
        $this->createTable('iit_uc_stock', $fileds);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_stock');
    }
}
