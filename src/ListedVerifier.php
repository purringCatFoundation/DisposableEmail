<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

/**
 * Simplest EmailVerifier.
 *
 * Class ListedVerifier
 * @package PCF\DisposableEmail
 */
class ListedVerifier extends AbstractPCFVerifier
{
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
            if (empty($list)) {
                continue;
            }

            if (in_array($domain, $list)) {
                return $status;
            }
        }

        return static::DOMAIN_UNKNOWN;
    }
}
