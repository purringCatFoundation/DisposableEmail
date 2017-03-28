<?php

declare(strict_types=1);

namespace PCF\DisposableEmailTest;

use PHPUnit\Framework\TestCase;
use PCF\DisposableEmail\SimpleDomainCollection;
use PCF\DisposableEmail\AbstractPCFVerifier;
use PCF\DisposableEmail\Exception\VerifyDomainException;

class AbstractPCFVerifierTest extends TestCase
{
    public function testNotSetDomainCollectionException(): void
    {
        $this->expectException(VerifyDomainException::class);
        $this->expectExceptionMessage('DomainCollection does not set');

        $verifier = new class extends AbstractPCFVerifier {
            protected function doVerifyDomain(string $domain): int
            {
                return self::DOMAIN_UNKNOWN;
            }
        };
        
        $verifier->verifyDomain('domain.com');
    }

    public function testEmptyStringException(): void
    {
        $this->expectException(VerifyDomainException::class);
        $this->expectExceptionMessage('Inserted domain is empty string');

        $collection = new SimpleDomainCollection();
        $verifier   = new class extends AbstractPCFVerifier
        {
            protected function doVerifyDomain(string $domain): int
            {
                return self::DOMAIN_UNKNOWN;
            }
        };
        $verifier->setDomainCollection($collection);

        $verifier->verifyDomain('');
    }
    
    public function testNotAcceptedStatus(): void
    {
        $this->expectException(VerifyDomainException::class);
        $this->expectExceptionMessage('Validation result status is not accepted. Maybe u used custom result?');

        $collection = new SimpleDomainCollection();
        $verifier   = new class extends AbstractPCFVerifier {
            protected function doVerifyDomain(string $domain): int
            {
                return PHP_INT_MAX;
            }
        };
        $verifier->setDomainCollection($collection);

        $verifier->verifyDomain('domain.com');
    }
}
