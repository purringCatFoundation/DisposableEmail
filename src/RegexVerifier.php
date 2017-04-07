<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

/**
 * Class RegexVerifier
 * @package PCF\DisposableEmail
 */
class RegexVerifier extends AbstractPCFVerifier
{
    const PREG_MATCH_FOUND_RETURN = 1;
    
    /**
     * @inheritdoc
     */
    protected function doVerifyDomain(string $domain): int
    {
        $lists = [
            static::DOMAIN_UNTRUSTED => $this->collection->getBlockedList(),
            static::DOMAIN_TRUSTED   => $this->collection->getTrustedList(),
            static::DOMAIN_KNOWN     => $this->collection->getKnownList(),
        ];

        foreach ($lists as $status => $list) {
            if (true === $this->pregList($list, $domain)) {
                return $status;
            }
        }

        return static::DOMAIN_UNKNOWN;
    }

    /**
     * @param string[] $list
     * @param string $domain
     *
     * @return bool
     */
    private function pregList(array $list, string $domain): bool
    {
        foreach ($list as $pattern) {
            if (self::PREG_MATCH_FOUND_RETURN === preg_match("/$pattern/", $domain)) {
                return true;
            }
        }

        return false;
    }
}
