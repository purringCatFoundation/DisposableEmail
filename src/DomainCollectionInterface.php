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
     * @return array
     */
    public function getTrustedList(): array;

    /**
     * @return array
     */
    public function getBlockedList(): array;

    /**
     * @return array
     */
    public function getKnownList(): array;
}
