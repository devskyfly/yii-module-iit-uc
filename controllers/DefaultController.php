<?php
namespace devskyfly\yiiModuleIitUc\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $title='Модуль "УЦ"';
        $list=[
            [
            'label'=>'',
            'sub_list'=>[
                ['name'=>'Услуги','route'=>'/iit-uc/stocks'],
                ['name'=>'Тарифы','route'=>'/iit-uc/rates'],
                ['name'=>'Площадки','route'=>'/iit-uc/sites'],
                ['name'=>'Доп. услуги','route'=>'/iit-uc/services'],
                ['name'=>'Пакеты доп. услуги','route'=>'/iit-uc/services-packages'],
                ['name'=>'Пономочия','route'=>'/iit-uc/powers'],
                ['name'=>'Пакеты полномочий','route'=>'/iit-uc/powers-packages'] 
            ]
            
        ]
        ];
        return $this->render('index',compact("list","title"));
    }
}