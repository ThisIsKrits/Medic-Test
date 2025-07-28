<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

class BaseEnum extends Enum
{
    public static function all($placeholder = null)
    {
        $list = [];
        $class = static::class;

        if ($placeholder) {
            $list[] = $placeholder;
        }

        foreach (static::toArray() as $key) {
            $list[$key] = __("enum.$class.$key");
        }

        return $list;
    }

    public static function valName($val)
    {
        $list = [];
        $class = static::class;

        foreach (static::toArray() as $key) {
            $list[$key] = __("enum.$class.$key");
        }

        return isset($list[$val]) ? $list[$val] : '-';
    }
}
