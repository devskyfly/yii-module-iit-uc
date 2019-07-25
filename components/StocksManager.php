<?
namespace devskyfly\yiiModuleIitUc\components;

use devskyfly\yiiModuleIitUc\models\stock\Stock;
use devskyfly\yiiModuleIitUc\models\rate\Rate;
use yii\base\InvalidArgumentException;
use yii\base\BaseObject;
use devskyfly\php56\types\Obj;

class StocksManager extends BaseObject
{
    
    /**
     * @param Rate $name
     * @throws InvalidArgumentException
     * @return Stock
     */
    public static function getStockByRate($model)
    {
        if (!Obj::isA($model, Rate::class)) {
            throw new InvalidArgumentException('Param $model is not '.Rate::class.' type.');
        }
        
        return Stock::find()
        ->where(['active'=>'Y','id'=>$model->_stock__id])
        ->one();
    }
}