<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Surfaces;

use SIF\Components\Exceptions\ValueTooLargeException;
use SIF\Components\Surfaces\Message;
use PHPUnit\Framework\TestCase;
use SIF\Components\Surfaces\Modal;

class ViewTest extends TestCase {

    public function testIdTooLong() {
        $this->expectException(ValueTooLargeException::class);
        $surface = new Modal([], bin2hex(random_bytes(255)));
    }

    public function testPrivateMetadataTooLong() {
        $this->expectException(ValueTooLargeException::class);
        $surface = new Modal([], 'id', 'Submit', 'Close', bin2hex(random_bytes(3000)));
    }

}
