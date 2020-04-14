<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Surfaces;

use SIF\Components\Blocks\Divider;
use SIF\Components\Compositions\Option;
use SIF\Components\Elements\Checkboxes;
use SIF\Components\Exceptions\BlockNotSupportedInSurfaceException;
use SIF\Components\Surfaces\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase {

    public function testSerialization() {
        $block = new Divider();
        $surface = new Message([$block]);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Message.json', json_encode($surface));
    }

    public function testUnsupportedBlock() {
        $this->expectException(BlockNotSupportedInSurfaceException::class);
        $block = new Checkboxes('checkboxid', [new Option('a', 'b')]);
        $surface = new Message([$block]);
    }

    public function testTypes() {
        $surface = new Message([]);
        $this->assertEquals('message', $surface->getType());
        $this->assertEquals('message', $surface->getBuilderType());
    }

    public function testSupports() {
        $surface = new Message([]);
        $this->assertIsArray($surface->supports());
    }

    public function testBlockKitUri() {
        $surface = new Message([]);
        $this->assertEqualsIgnoringCase('https://api.slack.com/tools/block-kit-builder?mode=message&view=%7B%22blocks%22%3A%5B%5D%7D', $surface->getBlockKitBuilderUri());
    }

}
