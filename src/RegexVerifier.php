<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

use PCF\DisposableEmail\Exception\VerifyDomainException;

class RegexVerifier implements EmailVerifierInterface
{
    /**
     * @var null|DomainCollectionInterface
     */
    private $collection;

    /**
     * ListedVerifier constructor.
     *
     * @param DomainCollectionInterface|null $collection
     */
    public function __construct(DomainCollectionInterface $collection = null)
    {
        $this->collection = $collection;
    }

    /**
     * @param DomainCollectionInterface $collection
     */
    public function setDomainCollection(DomainCollectionInterface $collection): void
    {
        $this->collection = $collection;
    }

    public function getDomainCollection(): ?DomainCollectionInterface
    {
        return $this->collection;
    }

    /**
     * {@inheritdoc}
     * This method will check whole lists
     *
     * @throws VerifyDomainException
     */
    public function verifyDomain(string $domain): int
    {
        if(empty($this->collection)) {
            throw new VerifyDomainException('DomainCollection does not set');
        }

        if(empty($domain)) {
            throw new VerifyDomainException('Inserted domain is empty string');
        }

        $lists = [
            self::DOMAIN_UNTRUSTED => $this->collection->getBlockedList(),
            self::DOMAIN_TRUSTED   => $this->collection->getTrustedList(),
            self::DOMAIN_KNOWN     => $this->collection->getKnownList(),
        ];

        foreach ($lists as $status => $list) {
            if(true === $this->pregList($lists, $domain)) {
                return $status;
            }
        }

        return self::DOMAIN_UNKNOWN;
    }

    /**
     * @param array $list
     * @param string $domain
     *
     * @return bool
     */
    private function pregList(array $list, string $domain): bool
    {
        if(empty($list)) {
            return false;
        }

        foreach ($list as $pattern) {
            if(false !== preg_match($pattern, $domain)) {
                return true;
            }
        }

        return false;
    }
}
