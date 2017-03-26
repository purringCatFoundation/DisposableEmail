<?php

declare(strict_types=1);

namespace PCF\DisposableEmailTest\Resource;

use PHPUnit\Framework\TestCase;
use PCF\DisposableEmail\Resource\AbstractResourceList;
use PCF\DisposableEmail\Exception\DisposableEmailException;

class AbstractResourceListTest extends TestCase
{
    public function testGetList(): void
    {
        $this->assertNotEmpty(AbstractResourceList::getList('block'));
        $this->assertNotEmpty(AbstractResourceList::getList('trust'));
    }
    
    public function testUnknowListException(): void
    {
        $this->expectException(DisposableEmailException::class);
        $this->expectExceptionMessage('test list not is not know list. Alredy know : block|trust');
        
        AbstractResourceList::getList('test');
    }
    
    public function testFileNotExistsException(): void
    {
        $fileName = time().'txt';
        
        $this->expectException(DisposableEmailException::class);
        $this->expectExceptionMessage($fileName.' file not exists.');
        
        $testClass = new class extends AbstractResourceList {
            public static function getList(string $listName): array
            {
                return self::parseFile($listName);
            }
        };
        
        $testClass::getList($fileName);
    }
}
