<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Compositions;

use SIF\Components\Compositions\OptionGroup;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\InvalidCompositionException;
use SIF\Components\Exceptions\OutOfRangeException;
use SIF\Components\Exceptions\ValueTooLargeException;

class OptionGroupTest extends TestCase {

    private array $options = [];

    public function setUp(): void {
        $this->options = [
            new \SIF\Components\Compositions\Option('Text1', 'value1', false, 'description', 'https://chemicalstrawberry.com'),
            new \SIF\Components\Compositions\Option('Text2', 'value2', false, 'description', 'https://chemicalstrawberry.com'),
        ];
    }

    public function testSerialization() {
        $block = new \SIF\Components\Compositions\OptionGroup('Label', $this->options);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/OptionGroup.json', json_encode($block));
    }

    public function testLabelTooLarge() {
        $this->expectException(\RangeException::class);
        new OptionGroup(bin2hex(random_bytes(100)), $this->options);
    }

    public function testEmptyOptions() {
        $this->expectException(OutOfRangeException::class);
        new OptionGroup('Test', []);
    }

    public function testInvalidOption() {
        $this->expectException(InvalidCompositionException::class);
        new OptionGroup('Test', ['invalid']);
    }

}
