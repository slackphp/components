<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Elements\Button;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\ValueTooLargeException;

class ButtonTest extends TestCase {

    use ConfirmTrait;

    public function setUp(): void {
        $this->setupConfirm();
    }

    public function testSerialization() {
        $button = new Button('testid', 'Test button', 'https://google.com', 'avalue', Button::STYLE_PRIMARY, $this->confirm);
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/Button.json', json_encode($button));
    }

    public function testTextTooLarge() {
        $this->expectException(ValueTooLargeException::class);
        new Button('testid', bin2hex(random_bytes(64)));
    }

    public function testUrlTooLarge() {
        $this->expectException(ValueTooLargeException::class);
        new Button('testid', 'Test button', bin2hex(random_bytes(2000)));
    }

    public function testValueTooLarge() {
        $this->expectException(ValueTooLargeException::class);
        new Button('testid', 'Test button', null, bin2hex(random_bytes(2000)));
    }

    public function testRequiredProperties() {
        $this->expectException(\ArgumentCountError::class);
        new Button();
    }

}
