<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

/**
 * A simple divider
 * @package SIF\Components\Blocks
 * @see https://api.slack.com/reference/block-kit/blocks#divider
 * @codeCoverageIgnore
 */
class Divider extends Block {

    protected string $type = 'divider';

}