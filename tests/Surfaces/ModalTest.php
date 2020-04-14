<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Surfaces;

use SIF\Components\Blocks\Divider;
use SIF\Components\Compositions\Option;
use SIF\Components\Elements\Checkboxes;
use SIF\Components\Exceptions\BlockNotSupportedInSurfaceException;
use SIF\Components\Exceptions\ValueTooLargeException;
use SIF\Components\Surfaces\Message;
use SIF\Components\Surfaces\Modal;
use PHPUnit\Framework\TestCase;

class ModalTest extends TestCase {

    public function testSerialization() {
        $block = new Divider();
        $surface = new Modal([$block], 'Title', 'id', 'Submit', 'Close', 'privatemeta', true, true, 'externalid');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Modal.json', json_encode($surface));
    }

    public function testTitleTooLong() {
        $this->expectException(ValueTooLargeException::class);
        new Modal([], bin2hex(random_bytes(24)));
    }

    public function testSubmitTooLong() {
        $this->expectException(ValueTooLargeException::class);
        new Modal([], 'title','id', bin2hex(random_bytes(24)));
    }

    public function testCloseTooLong() {
        $this->expectException(ValueTooLargeException::class);
        new Modal([], 'title','id', 'Submit', bin2hex(random_bytes(24)));
    }

    public function testUnsupportedBlock() {
        $this->expectException(BlockNotSupportedInSurfaceException::class);
        $block = new Checkboxes('checkboxid', [new Option('a', 'b')]);
        $surface = new Modal([$block], 'id');
    }

    public function testTypes() {
        $surface = new Modal([], 'id');
        $this->assertEquals('modal', $surface->getType());
        $this->assertEquals('modal', $surface->getBuilderType());
    }

    public function testSupports() {
        $surface = new Modal([], 'id');
        $this->assertIsArray($surface->supports());
    }

    public function testBlockKitUri() {
        $surface = new Modal([], 'id');
        $this->assertEqualsIgnoringCase('https://api.slack.com/tools/block-kit-builder?mode=modal&view=%7B%22title%22%3A%7B%22type%22%3A%22plain_text%22%2C%22text%22%3A%22id%22%2C%22emoji%22%3Afalse%7D%2C%22clear_on_close%22%3Afalse%2C%22notify_on_close%22%3Afalse%2C%22type%22%3A%22modal%22%2C%22blocks%22%3A%5B%5D%7D', $surface->getBlockKitBuilderUri());
    }

}
