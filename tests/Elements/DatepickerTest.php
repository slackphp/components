<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Elements\Datepicker;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\ValueTooLargeException;

class DatepickerTest extends TestCase {

    use ConfirmTrait;

    public function setUp(): void {
        $this->setupConfirm();
    }

    public function testSerialization() {
        $block = new Datepicker('datepickerid', 'Placeholder', new \DateTime('now'), $this->confirm);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Datepicker.json', json_encode($block));
    }

    public function testTextTooLong() {
        $this->expectException(\RangeException::class);
        new Datepicker('datepickerid', bin2hex(random_bytes(300)));
    }

    public function testDefaultDate() {
        $block = new Datepicker('datepickerid', 'Placeholder');
        $now = (new \DateTime('now'))->format('Y-m-d');
        $this->assertEquals($now, $block->initialDate->format('Y-m-d'));
    }

}
