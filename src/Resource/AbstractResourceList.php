<?php

declare(strict_types=1);

namespace PCF\DisposableEmail\Resource;

/**
 * Class AbstractResourceList
 * @package PCF\DisposableEmail\Resource
 */
abstract class AbstractResourceList
{
    /**
     * @var string
     */
    protected static $list = '';

    /**
     * @return array
     */
    public static function getList(): array
    {
        return explode(PHP_EOL, trim(static::$list));
    }
}
