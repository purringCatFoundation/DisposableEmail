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
     * @dataProvider verifyEmailDataProvider
     *
     * @param SimpleDomainCollection $collection
     * @param string $email
     * @param int $expectedStatus
     */
    public function testVerifyEmail(SimpleDomainCollection $collection, string $email, int $expectedStatus): void
    {
        $verifier = new RegexVerifier($collection);
        $actualStatus = $verifier->verifyEmail($email);

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

    /**
     * @return array
     */
    public function verifyEmailDataProvider()
    {
        $testCases = $this->verifyTestDataProvider();

        foreach ($testCases as $key => $val) {
            $testCases[$key][1] = 'test@' . $val[1];
        }

        return $testCases;
    }
}
