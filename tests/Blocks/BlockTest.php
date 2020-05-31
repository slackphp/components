<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\Block;
use PHPUnit\Framework\TestCase;
use SIF\Components\Blocks\Divider;

class BlockTest extends TestCase {

    private Block $block;

    protected function setUp() : void {
        $this->block = new class extends Block {
            protected string $type = 'test';
        };
    }

    public function testSerialization() {
        $block = $this->block;
        $block->id = 'testid';
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Block.json', json_encode($block));
    }

    public function testBlockIdTooLong() {
        $this->expectException(\RangeException::class);
        new Divider(bin2hex(random_bytes(256))); // doesn't matter which block, just need to set the id
    }

}
