<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Elements\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase {

    public function testSerialization() {
        $image = new Image('https://docs.chemicalstrawberry.com/sif/components/logo.png', 'Image');
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Image.json', json_encode($image));
    }

}
