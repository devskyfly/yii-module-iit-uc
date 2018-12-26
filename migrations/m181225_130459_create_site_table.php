<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\db\Migration;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `site`.
 */
class m181225_130459_create_site_table extends EntityMigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fileds=ArrayHelper::merge($this->getFieldsDefinition(), [
            "url"=>$this->string(255),
        ]);
        
        $this->createTable('iit_uc_site', $fileds);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_site');
    }
}
