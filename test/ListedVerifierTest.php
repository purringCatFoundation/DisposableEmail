<?php

declare(strict_types=1);

namespace PCF\DisposableEmailTest;

use PCF\DisposableEmail\Exception\VerifyDomainException;
use PCF\DisposableEmail\ListedVerifier;
use PCF\DisposableEmail\SimpleDomainCollection;
use PHPUnit\Framework\TestCase;

class ListedVerifierTest extends TestCase
{

    public function testNotSetDomainCollectionException(): void
    {
        $this->expectException(VerifyDomainException::class);
        $this->expectExceptionMessage('DomainCollection does not set');

        $verifier = new ListedVerifier();
        $verifier->verifyDomain('aaa.com');
    }

    public function testEmptyStringException(): void
    {
        $this->expectException(VerifyDomainException::class);
        $this->expectExceptionMessage('Inserted domain is empty string');

        $collection = new SimpleDomainCollection();
        $verifier   = new ListedVerifier($collection);

        $verifier->verifyDomain('');
    }
}
