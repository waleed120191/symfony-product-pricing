<?php

namespace App\Enum;

abstract class PlEnum
{
    const TYPE_FOR = "for";
    const TYPE_KG = "kg";
    const TYPE_BUY_GET_FREE = "buy_get_free";

    /** @var array user friendly named type */
    protected static $typeName = [
        self::TYPE_FOR => 'For',
        self::TYPE_KG => 'KG',
        self::TYPE_BUY_GET_FREE => 'Buy get free',
    ];

    /**
     * @param  string $typeShortName
     * @return string
     */
    public static function getTypeName($typeShortName)
    {
        if (!isset(static::$typeName[$typeShortName])) {
            return "Unknown type ($typeShortName)";
        }

        return static::$typeName[$typeShortName];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::TYPE_FOR,
            self::TYPE_KG,
            self::TYPE_BUY_GET_FREE
        ];
    }
}