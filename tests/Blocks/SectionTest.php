<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\Section;
use PHPUnit\Framework\TestCase;
use SIF\Components\Compositions\Text;
use SIF\Components\Elements\Button;
use SIF\Components\Elements\Element;
use SIF\Components\Exceptions\ElementNotSupportedInBlockException;

class SectionTest extends TestCase {

    public function testSerialization() : void {
        $block = new Section('test', ['test'], new Button('test', 'test'), 'testid');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Section.json', json_encode($block));
    }

    public function testTextTooLong() : void {
        $this->expectException(\RangeException::class);
        new Section(bin2hex(random_bytes(6000)));
    }

    public function testTextFieldConversions() : void {
        $elements = ['test'];
        $section = new Section('test', $elements);
        $this->assertInstanceOf(Text::class, $section->fields[0]);
    }

    public function testFieldsTooMany() : void {
        $elements = array_fill(0, 50, 'test');

        $this->expectException(\RangeException::class);
        new Section('test', $elements);
    }

    public function testUnsupportedElement() : void {
        $element = new class() extends Element{};

        $this->expectException(ElementNotSupportedInBlockException::class);
        new Section('test', null, $element);
    }

}
