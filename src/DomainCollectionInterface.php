<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

/**
 * Interface DomainCollectionInterface
 *
 * @package PCF\DisposableEmail\Verifier
 */
interface DomainCollectionInterface
{
    /**
     * @return string[]
     */
    public function getTrustedList(): array;

    /**
     * @return string[]
     */
    public function getBlockedList(): array;

    /**
     * @return string[]
     */
    public function getKnownList(): array;
}
