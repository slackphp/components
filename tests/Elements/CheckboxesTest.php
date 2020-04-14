<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Compositions\Option;
use SIF\Components\Elements\Checkboxes;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

class CheckboxesTest extends TestCase {

    use ConfirmTrait;

    public function setUp(): void {
        $this->setupConfirm();
    }

    public function testSerialization() {
        // make a few checkboxes first, this is tested elsewhere so we're only adding the required properties with sensible values
        $checkbox = [];
        for($i = 0; $i < 5; ++$i) {
            $checkbox[] = new Option('Test Checkbox '.$i, 'testid-'.$i, true);
        }

        $checkboxes = new Checkboxes('checkboxesid', $checkbox, $this->confirm);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/Checkboxes.json', json_encode($checkboxes));
    }

    public function testRequiredProperties() {
        $this->expectException(\ArgumentCountError::class);
        new Checkboxes();
    }

    public function testInvalidOption() {
        $this->expectException(InvalidOptionException::class);
        $checkboxes = new Checkboxes('checkboxesid', ['invalid']);
    }

    public function testEmptyOptions() {
        $this->expectException(OutOfRangeException::class);
        $checkboxes = new Checkboxes('checkboxesid', []);
    }

}
