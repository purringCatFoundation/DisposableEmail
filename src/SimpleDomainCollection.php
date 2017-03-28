<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

/**
 * Class DisposableSimpleList
 * @package PCF\DisposableEmail
 */
class SimpleDomainCollection implements DomainCollectionInterface
{
    /**
     * @var string[]
     */
    private $trustedList = [];

    /**
     * @var string[]
     */
    private $blockedList = [];

    /**
     * @var string[]
     */
    private $knownList = [];

    /**
     * @return string[]
     */
    public function getTrustedList(): array
    {
        return $this->trustedList;
    }

    /**
     * @param string[] $list
     */
    public function setTrustedList(array $list): void
    {
        $this->trustedList = $list;
    }

    /**
     * @return string[]
     */
    public function getBlockedList(): array
    {
        return $this->blockedList;
    }

    /**
     * @param string[] $list
     */
    public function setBlockedList(array $list): void
    {
        $this->blockedList = $list;
    }

    /**
     * @return string[]
     */
    public function getKnownList(): array
    {
        return $this->knownList;
    }

    /**
     * @param string[] $list
     */
    public function setKnownList(array $list): void
    {
        $this->knownList = $list;
    }
}
