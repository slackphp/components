<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Compositions;

use PHPUnit\Framework\TestCase;
use SIF\Components\Compositions\Confirm;
use SIF\Components\Exceptions\ValueTooLargeException;

class ConfirmTest extends TestCase {

    public function testSerialization() {
        $confirm = new Confirm('A title', 'Some text', 'Confirm', 'Deny');
        $confirmSerialized = json_encode($confirm);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/Confirm.json', $confirmSerialized);
    }

    public function testTitleTooLarge() {
        $this->expectException(\RangeException::class);
        new Confirm(bin2hex(random_bytes(100)), 'Text');
    }

    public function testTextTooLarge() {
        $this->expectException(\RangeException::class);
        new Confirm('Title', bin2hex(random_bytes(300)));
    }

    public function testConfirmButtonTooLarge() {
        $this->expectException(\RangeException::class);
        new Confirm('Title', 'Text', bin2hex(random_bytes(300)));
    }

    public function testDenyButtonTooLarge() {
        $this->expectException(\RangeException::class);
        new Confirm('Title', 'Text', 'Confirm', bin2hex(random_bytes(300)));
    }

}