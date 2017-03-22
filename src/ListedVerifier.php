<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

use PCF\DisposableEmail\Exception\VerifyDomainException;

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
            self::DOMAIN_UNTRUSTED => $this->collection->getBlockedList(),
            self::DOMAIN_TRUSTED   => $this->collection->getTrustedList(),
            self::DOMAIN_KNOWN     => $this->collection->getKnownList(),
        ];

        foreach ($lists as $status => $list) {
            if (empty($list)) {
                continue;
            }

            if (in_array($domain, $list)) {
                return $status;
            }
        }

        return self::DOMAIN_UNKNOWN;
    }
}
