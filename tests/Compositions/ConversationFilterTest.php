<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Compositions;

use SIF\Components\Compositions\ConversationFilter;
use PHPUnit\Framework\TestCase;
use SIF\Components\Exceptions\OutOfRangeException;

class ConversationFilterTest extends TestCase {

    public function testSerialization() {
        $block = new ConversationFilter();
        $this->assertJsonStringEqualsJsonFile(__DIR__ . '/ConversationFilter.json', json_encode($block));
    }

    public function testNoFilters() {
        $this->expectException(OutOfRangeException::class);
        new ConversationFilter([]);
    }

}
