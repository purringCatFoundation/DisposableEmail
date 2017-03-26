<?php

declare(strict_types=1);

namespace PCF\DisposableEmailTest;

use PCF\DisposableEmail\ListedVerifier;
use PCF\DisposableEmail\SimpleDomainCollection;
use PHPUnit\Framework\TestCase;

class ListedVerifierTest extends TestCase
{
    /**
     * @dataProvider verifyTestDataProvider
     *
     * @param SimpleDomainCollection $collection
     * @param string                 $testDomain
     * @param int                    $expectedStatus
     */
    public function testVerify(SimpleDomainCollection $collection, string $testDomain, int $expectedStatus): void
    {
        $verifier = new ListedVerifier($collection);
        $actualStatus = $verifier->verifyDomain($testDomain);

        $this->assertEquals($expectedStatus, $actualStatus);
    }

    /**
     * @return array
     */
    public function verifyTestDataProvider(): array
    {
        $collection = new SimpleDomainCollection();
        $collection->setBlockedList([
            'domain1.test',
            'domain2.test',
            'domain3.test'
        ]);
        $collection->setTrustedList([
            'domain2.test',
            'domain4.test',
            'domain5.test'
        ]);
        $collection->setKnownList([
            'domain3.test',
            'domain5.test',
            'domain6.test'
        ]);

        return [
            [ $collection, 'domain1.test', ListedVerifier::DOMAIN_UNTRUSTED ],
            [ $collection, 'domain2.test', ListedVerifier::DOMAIN_UNTRUSTED ],
            [ $collection, 'domain3.test', ListedVerifier::DOMAIN_UNTRUSTED ],
            [ $collection, 'domain4.test', ListedVerifier::DOMAIN_TRUSTED   ],
            [ $collection, 'domain5.test', ListedVerifier::DOMAIN_TRUSTED   ],
            [ $collection, 'domain6.test', ListedVerifier::DOMAIN_KNOWN     ],
            [ $collection, 'domain7.test', ListedVerifier::DOMAIN_UNKNOWN   ],
        ];
    }
}
