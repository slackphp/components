<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase {

    public function testSerialization() : void {
        $file = new File('id');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/File.json', json_encode($file));
    }

}
