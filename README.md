# Disposable email domains filter

Our domain repositories comes from [repository](https://github.com/martenson/disposable-email-domains) licensed by [Public Domain License(CC0 1.0)](https://creativecommons.org/publicdomain/zero/1.0/).
 
Domain repository date: [10.03.2017](https://github.com/martenson/disposable-email-domains/commit/e68bd490c6a8fa10012128955df86facfe4028e9)


These repository is contributed by [MIT License](LICENSE) but files [blocklist.conf](src/Resource/lists/blocklist.conf) and [trustlist.conf](src/Resource/lists/trustlist.conf) are contributed by [Public Domain License(CC0 1.0)](https://creativecommons.org/publicdomain/zero/1.0/).

# Basic Usage

```PHP
<?php

require 'vendor/autoload.php';

use PCF\DisposableEmail\ListedVerifier;
use PCF\DisposableEmail\SimpleDomainCollection;
use PCF\DisposableEmail\Resource\AbstractResourceList;

$collection = new SimpleDomainCollection();
$collection->setBlockedList(AbstractResourceList::getList('block'));
$collection->setTrustedList(AbstractResourceList::getList('trust'));
$collection->setKnownList([
    //Add domains that you know, if you want
]);

$verifier = new ListedVerifier($collection);

$mail = 'paw.radzikowski@gmail.com';
list($localPart, $domain) = explode('@', $mail);

$status = $verifier->verifyDomain($domain); //It should return ListedVerifier::DOMAIN_UNKNOWN
```

#Versions

Version of this composer lib look like `1.0.201707401` which is contains Major version. Minor version. Year, day of year and commit version. 
It should help with mail repository versioning.
