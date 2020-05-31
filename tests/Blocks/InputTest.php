<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\Input;
use PHPUnit\Framework\TestCase;
use SIF\Components\Elements\PlaintextInput;
use SIF\Components\Exceptions\ElementNotSupportedInBlockException;

class InputTest extends TestCase {

    public function testSerialization() : void {
        $input = new Input('Test', new PlaintextInput('test'), 'testhint', true, 'testid');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Input.json', json_encode($input));
    }

    public function testHintTooLong() : void {
        $this->expectException(\RangeException::class);
        new Input('test', new PlaintextInput('test'), bin2hex(random_bytes(2000)));
    }

    public function testLabelTooLong() : void {
        $this->expectException(\RangeException::class);
        new Input(bin2hex(random_bytes(2000)),  new PlaintextInput('test'), 'test');
    }

    public function testUnsupportedElement() : void {
        $this->expectException(ElementNotSupportedInBlockException::class);
        new Input('test', new \stdClass());
    }

}
