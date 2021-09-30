<?php
namespace devskyfly\yiiModuleIitUc\controllers\rest;

use devskyfly\yiiModuleIitUc\models\power\Power;
use yii\helpers\Json;

/**
 * Rest api class
 */
class PowersController extends CommonController
{
    /**
     * Return powers
     * GET
     *
     * Return:
     * [
     *  [
     *      id: number,
     *      name: string,
     *      oid: string
     *  ],...
     * ]
     */
    public function actionIndex()
    {
        $data=[];
        $power_cls=Power::class;
        
        $items=$power_cls::find()
        ->where(['active'=>'Y'])
        ->orderBy(['sort'=>SORT_ASC])
        ->all();
        
        foreach ($items as $item){
            $data[]=[
                "id"=>$item->id,
                "name"=>empty($item->detail_text)?$item->name:$item->detail_text,
                "oid"=>$item->oid,
                "clients_type"=>Json::decode($item->client_type)
            ];
        }
        
        $this->asJson($data);
    }
}