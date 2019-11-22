<?php
namespace devskyfly\yiiModuleIitUc\helpers;

use devskyfly\php56\types\Vrbl;

class ModelsFilter
{
    public static function getActive($items)
    {
        $callback = function ($item) {
            if (Vrbl::isNull($item)) {
                return false;
            }

            if ($item->active == 'Y') {
                return true;
            } else {
                return false;
            }
        };

        return array_filter($items, $callback);
    }
}