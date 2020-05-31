<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\Context;
use PHPUnit\Framework\TestCase;
use SIF\Components\Compositions\Text;
use SIF\Components\Elements\PlaintextInput;
use SIF\Components\Exceptions\ElementNotSupportedInBlockException;

class ContextTest extends TestCase {

    public function testSerialization(): void {
        $context = new Context([new Text('some text')], 'id');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Context.json', json_encode($context));
    }

    public function testElementsEmpty() : void {
        $this->expectException(\RangeException::class);
        new Context([], 'id');
    }

    public function testElementsTooMany() : void {
        $elements = array_fill(0, 10, new PlaintextInput('test'));

        $this->expectException(\RangeException::class);
        new Context($elements, 'id');
    }

    public function testUnsupportedElement() : void {
        $this->expectException(ElementNotSupportedInBlockException::class);
        new Context([new \stdClass()], 'id');
    }

}
