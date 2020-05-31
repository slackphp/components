<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Elements\PlaintextInput;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\OutOfRangeException;
use SIF\Components\Exceptions\ValueTooLargeException;

class PlaintextInputTest extends TestCase {

    public function testSerialization() {
        $text = new PlaintextInput('textid', 'Placeholder', 'init value', true, 10, 100);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/PlaintextInput.json', json_encode($text));
    }

    public function testPlaceholderTooLarge() {
        $this->expectException(\RangeException::class);
        new PlaintextInput('id', bin2hex(random_bytes(300)));
    }

    public function testMinimumLengthTooLarge() {
        $this->expectException(\RangeException::class);
        new PlaintextInput('id', 'placeholder', 'a', true, 10000);
    }

}
