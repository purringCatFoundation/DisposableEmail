<?php

declare(strict_types=1);

namespace PCF\DisposableEmailTest;

use PCF\DisposableEmail\RegexVerifier;
use PCF\DisposableEmail\SimpleDomainCollection;
use PHPUnit\Framework\TestCase;

class RegexVerifierTest extends TestCase
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

        $verifier = new RegexVerifier($collection);
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
            '^domain(1|2|3).test',
        ]);
        $collection->setTrustedList([
            '^domain(2|4|5).test',
        ]);
        $collection->setKnownList([
            '^domain(3|5|6).test',
        ]);

        return [
            [ $collection, 'domain1.test', RegexVerifier::DOMAIN_UNTRUSTED ],
            [ $collection, 'domain2.test', RegexVerifier::DOMAIN_UNTRUSTED ],
            [ $collection, 'domain3.test', RegexVerifier::DOMAIN_UNTRUSTED ],
            [ $collection, 'domain4.test', RegexVerifier::DOMAIN_TRUSTED   ],
            [ $collection, 'domain5.test', RegexVerifier::DOMAIN_TRUSTED   ],
            [ $collection, 'domain6.test', RegexVerifier::DOMAIN_KNOWN     ],
            [ $collection, 'domain7.test', RegexVerifier::DOMAIN_UNKNOWN   ],
        ];
    }
}
