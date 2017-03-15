<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

interface DomainCollectionInterface
{
    public function getTrustedList(): array;

    public function getBlockedList(): array;

    public function getKnownList(): array;
}
