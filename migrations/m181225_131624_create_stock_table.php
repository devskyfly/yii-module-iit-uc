<?php

use yii\db\Migration;

/**
 * Handles the creation of table `stock`.
 */
class m181225_131624_create_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('iit_uc_stock', $this->getFieldsDefinition());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('iit_uc_stock');
    }
}
