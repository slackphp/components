<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\Actions;
use PHPUnit\Framework\TestCase;
use SIF\Components\Elements\Element;
use SIF\Components\Elements\PlaintextInput;
use SIF\Components\Exceptions\ElementNotSupportedInBlockException;

class ActionsTest extends TestCase {

    public function testSerialization(): void {
        $action = new Actions([new PlaintextInput('elementid')], 'actionid');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Actions.json', json_encode($action));
    }

    public function testElementsEmpty() : void {
        $this->expectException(\RangeException::class);
        new Actions([], 'actionid');
    }

    public function testElementsTooMany() : void {
        $elements = array_fill(0, 10, new PlaintextInput('test'));

        $this->expectException(\RangeException::class);
        new Actions($elements, 'actionid');
    }

    public function testUnsupportedElement() : void {
        $this->expectException(ElementNotSupportedInBlockException::class);
        new Actions([new \stdClass()], 'testid');
    }

}
