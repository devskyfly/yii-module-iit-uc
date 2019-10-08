<?php

use devskyfly\yiiModuleAdminPanel\migrations\helpers\contentPanel\EntityMigrationHelper;
use yii\helpers\ArrayHelper;

/**
 * Handles the creation of table `rate_bundle`.
 */
class m191007_120404_create_rate_bundle_table extends EntityMigrationHelper
{
    public $table = "iit_uc_rate_bundle";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $fields = ArrayHelper::merge($this->getFieldsDefinition(), [
            "_parent_rate__id"=>$this->integer(11),
            "price"=>$this->string(11),
            "_stock__id"=>$this->integer(11),
            "slx_id"=>$this->string(20),
            "calc_name"=> $this->string(255),
            "client_type"=> $this->text(),
            "comment"=> $this->text(),
            "tooltip"=> $this->text(),
            "flag_for_license"=>"ENUM('Y','N') DEFAULT 'N' NOT NULL",
            "flag_for_crypto_pro"=>"ENUM('Y','N') DEFAULT 'N' NOT NULL",
            "flag_is_terminated"=>"ENUM('Y','N') DEFAULT 'N' NOT NULL"
        ]);
        
        $this->createTable($this->table, $fields);

        //$sql="ALTER TABLE {$this->table} ADD COLUMN client_type TEXT;";
        //$sql.="ALTER TABLE {$this->table} ADD COLUMN comment TEXT;";
        //$sql.="ALTER TABLE {$this->table} ADD COLUMN tooltip TEXT;";
        /*$sql.="ALTER TABLE {$this->table} ADD COLUMN flag_for_license ENUM('Y','N') DEFAULT 'N' NOT NULL;";
        $sql.="ALTER TABLE {$this->table} ADD COLUMN flag_for_crypto_pro ENUM('Y','N') DEFAULT 'N' NOT NULL;";
        $sql.="ALTER TABLE {$this->table} ADD COLUMN flag_is_terminated ENUM('Y','N') DEFAULT 'N' NOT NULL;";
        
        $this->execute($sql);*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
