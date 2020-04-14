<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Compositions\Option;
use SIF\Components\Elements\Checkboxes;
use PHPUnit\Framework\TestCase;
use SIF\Components\Elements\RadioButtons;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

class RadioButtonsTest extends TestCase {

    use ConfirmTrait;

    public function setUp(): void {
        $this->setupConfirm();
    }

    public function testSerialization() {
        $options = [];
        for($i = 0; $i < 5; ++$i) {
            $options[] = new Option('Test Radio '.$i, 'testid-'.$i, true);
        }

        $radio = new RadioButtons('radioid', $options, $this->confirm);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/RadioButtons.json', json_encode($radio));
    }

    public function testRequiredProperties() {
        $this->expectException(\ArgumentCountError::class);
        new RadioButtons();
    }

    public function testInvalidOption() {
        $this->expectException(InvalidOptionException::class);
        $checkboxes = new RadioButtons('radioid', ['invalid']);
    }

    public function testEmptyOptions() {
        $this->expectException(OutOfRangeException::class);
        $checkboxes = new RadioButtons('radioid',[]);
    }

}
