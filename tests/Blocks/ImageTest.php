<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Blocks;

use SIF\Components\Blocks\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase {

    public function testSerialization(): void {
        $image = new Image('https://docs.chemicalstrawberry.com/assets/images/sif-logo.png', 'SIF', 'Title', 'testid');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Image.json', json_encode($image));
    }

    public function testTitleTooLongException(): void {
        $this->expectException(\RangeException::class);
        new Image('https://docs.chemicalstrawberry.com/assets/images/sif-logo.png', 'test', bin2hex(random_bytes(2000)));
    }

}
