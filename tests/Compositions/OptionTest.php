<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Compositions;

use SIF\Components\Compositions\Option;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\ValueTooLargeException;

class OptionTest extends TestCase {

    public function testSerialization() {
        $block = new Option('Text', 'value', false, 'description', 'https://chemicalstrawberry.com');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Option.json', json_encode($block));
    }

    public function testTextTooLarge() {
        $this->expectException(\RangeException::class);
        new Option(bin2hex(random_bytes(100)), 'value');
    }

    public function testValueTooLarge() {
        $this->expectException(\RangeException::class);
        new Option('text', bin2hex(random_bytes(100)));
    }

    public function testDescriptionTooLarge() {
        $this->expectException(\RangeException::class);
        new Option('text', 'value', false, bin2hex(random_bytes(100)));
    }

}
