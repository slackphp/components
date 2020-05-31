<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\Divider;
use PHPUnit\Framework\TestCase;

class DividerTest extends TestCase {

    public function testSerialization() {
        $divider = new Divider();
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Divider.json', json_encode($divider));
    }

}
