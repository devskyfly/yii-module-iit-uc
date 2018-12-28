<?php
namespace devskyfly\yiiModuleIitUc\console\service;

use yii\console\Controller;
use yii\db\Migration;
use yii\helpers\Json;
use devskyfly\yiiModuleIitUc\models\site\Site;
use devskyfly\yiiModuleIitUc\models\site\SiteSection;
use Yii;
use yii\helpers\BaseConsole;
use yii\console\ExitCode;

class DbController extends Controller
{
    public function actionClear()
    {
        try {
            $db=Yii::$app->db;
            $schema=$db->schema;
            $tables=$schema->getTableNames();
            
            $migration=new Migration();
            foreach ($tables as $table){
                if(preg_match("/^iit_uc.*/", $table)){
                    $migration->truncateTable($table);
                }
            }
        }catch (\Exception $e){
            BaseConsole::stdout($e->getMessage());
            BaseConsole::stdout(PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        catch (\Throwable $e){
            BaseConsole::stdout($e->getMessage());
            return ExitCode::UNSPECIFIED_ERROR;
        }
        return ExitCode::OK;
    }
   
}