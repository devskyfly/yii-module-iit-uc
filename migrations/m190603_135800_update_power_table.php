<?php

use yii\db\Migration;
use devskyfly\yiiModuleIitUc\models\power\Power;
use yii\helpers\BaseConsole;

/**
 * Class m190603_135800_update_power_table
 */
class m190603_135800_update_power_table extends Migration
{

   
    public function up()
    {
        $items = Power::find()->where([])->all();
        foreach($items as $item){
            $item->sort='500';
            if(!$item->saveLikeItem()){
                BaseConsole::stdout('Не могу обновить '.$item->name).PHP_EOL;
            }
        }
    }

    public function down()
    {
        echo "m190603_135800_update_power_table cannot be reverted.\n";      
    }
   
}
