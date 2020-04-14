<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Compositions\Option;
use SIF\Components\Elements\Overflow;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

class OverflowTest extends TestCase {

    use ConfirmTrait;

    private array $options = [];

    public function setUp() : void {
        $this->setupConfirm();

        for($i = 0; $i < 5; ++$i) {
            $this->options[] = new Option('Test Option '.$i, 'testid-'.$i);
        }
    }

    public function testSerialization() {
        $overflow = new Overflow('overflowid', $this->options, $this->confirm);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Overflow.json', json_encode($overflow));
    }

    public function testInvalidOption() {
        $this->expectException(InvalidOptionException::class);
        $checkboxes = new Overflow('overflowid', ['invalid']);
    }

    public function testEmptyOptions() {
        $this->expectException(OutOfRangeException::class);
        $checkboxes = new Overflow('overflowid', []);
    }

}
