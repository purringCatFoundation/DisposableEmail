<?php

declare(strict_types=1);

namespace PCF\DisposableEmail\Resource;

use PCF\DisposableEmail\Exception\DisposableEmailException;

/**
 * Class AbstractResourceList
 * @package PCF\DisposableEmail\Resource
 */
abstract class AbstractResourceList
{
    public const DISPOSABLE_LIB_PATH = __DIR__.DIRECTORY_SEPARATOR.'lists'.DIRECTORY_SEPARATOR;
    
    /**
     * @param string $listName
     * 
     * @return array
     * 
     * @throws DisposableEmailException
     */
    public static function getList(string $listName): array
    {
        if ('block' === $listName) {
            return self::readFile(static::DISPOSABLE_LIB_PATH.'blocklist.conf');
        }
        
        if ('trust' === $listName) {
            return self::readFile(static::DISPOSABLE_LIB_PATH.'trustlist.conf');
        }
        
        throw new DisposableEmailException($listName.' list not is not know list. Alredy know : block|trust');
    }
    
    /**
     * @param string $path
     * 
     * @return array
     * 
     * @throws DisposableEmailException
     */
    protected static function readFile(string $path): array
    {
        if (false === file_exists($path)) {
            throw new DisposableEmailException($path.' file not exists.');
        }
        
        $content = file_get_contents($path);
        
        return explode(PHP_EOL, trim($content));
    }
}
