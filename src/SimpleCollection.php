<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

/**
 * Class DisposableSimpleList
 * @package PCF\DisposableEmail
 */
class SimpleDomainCollection implements DomainCollectionInterface
{
    private $trustedList = [];
    private $blockedList = [];
    private $knownList   = [];

    /**
     * @return array
     */
    public function getTrustedList(): array
    {
        return $this->trustedList;
    }

    /**
     * @param array $list
     */
    public function setTrustedList(array $list): void
    {
        $this->trustedList = $list;
    }

    /**
     * @return array
     */
    public function getBlockedList(): array
    {
        return $this->blockedList;
    }

    /**
     * @param array $list
     */
    public function setBlockedList(array $list): void
    {
        $this->blockedList = $list;
    }

    /**
     * @return array
     */
    public function getKnownList(): array
    {
        return $this->knownList;
    }

    /**
     * @param array $list
     */
    public function setKnownList(array $list): void
    {
        $this->knownList = $list;
    }
}
