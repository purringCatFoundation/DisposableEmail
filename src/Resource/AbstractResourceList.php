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

    public const LIST_BLOCK = 'block';

    public const LIST_TRUST = 'trust';
    
    /**
     * Return array of resourced domain list.
     * Possible lists:
     * <ul>
     *      <li> block (const LIST_BLOCK) - list of untrusted, evil, bad domains. </li>
     *      <li> trust (const LIST_TRUST) - list of trusted, good domains</li>
     * </ul>
     *
     * @param string $listName
     *
     * @return string[]
     *
     * @throws DisposableEmailException
     */
    public static function getList(string $listName): array
    {
        if (self::LIST_BLOCK === $listName) {
            return self::parseFile(static::DISPOSABLE_LIB_PATH.'blocklist.conf');
        }
        
        if (self::LIST_TRUST === $listName) {
            return self::parseFile(static::DISPOSABLE_LIB_PATH.'trustlist.conf');
        }
        
        throw new DisposableEmailException($listName.' list not is not know list. Alredy know : block|trust');
    }
    
    /**
     * @param string $path
     *
     * @return string[]
     *
     * @throws DisposableEmailException
     */
    protected static function parseFile(string $path): array
    {
        if (false === file_exists($path)) {
            throw new DisposableEmailException($path.' file not exists.');
        }
        
        $content = file_get_contents($path);
        
        return explode(PHP_EOL, trim($content));
    }
}
