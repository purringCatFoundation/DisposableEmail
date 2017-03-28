<?php

declare(strict_types=1);

namespace PCF\DisposableEmail;

use PCF\DisposableEmail\Exception\VerifyDomainException;

/**
 * Class AbstractPCFVerifier
 * @package PCF\DisposableEmail
 */
abstract class AbstractPCFVerifier implements EmailVerifierInterface
{
    /**
     * @var null|DomainCollectionInterface
     */
    protected $collection;

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

    /**
     * @return DomainCollectionInterface|null
     */
    public function getDomainCollection(): ?DomainCollectionInterface
    {
        return $this->collection;
    }
    
    /**
     * {@inheritdoc}
     * This method will check whole lists
     *
     * @param string $domain
     *
     * @return int
     */
    final public function verifyDomain(string $domain): int
    {
        $this->validateEntry($domain);
        
        $result = $this->doVerifyDomain($domain);
        
        $this->validateOutput($result, $domain);
        
        return $result;
    }
    
    /**
     * @param string $domain
     *
     * @throws VerifyDomainException
     */
    protected function validateEntry(string $domain): void
    {
        if (empty($this->collection)) {
            throw new VerifyDomainException('DomainCollection does not set');
        }

        if (empty($domain)) {
            throw new VerifyDomainException('Inserted domain is empty string');
        }
    }
    
    /**
     * @param int    $validationResult
     * @param string $domain
     *
     * @throws VerifyDomainException
     */
    protected function validateOutput(int $validationResult, string $domain): void
    {
        $possibleDomainStatuses = [
            static::DOMAIN_UNTRUSTED,
            static::DOMAIN_TRUSTED,
            static::DOMAIN_KNOWN,
            static::DOMAIN_UNKNOWN,
        ];
        
        if (false === in_array($validationResult, $possibleDomainStatuses)) {
            throw new VerifyDomainException('Validation result status is not accepted. Maybe u used custom result?');
        }
    }
    
    /**
     * @param string $domain
     *
     * @return int
     */
    abstract protected function doVerifyDomain(string $domain): int;
}
