<?php
declare(strict_types=1);

namespace SIF\Components\Compositions;

/**
 * A composition object
 * @package SIF\Components\Compositions
 * @see https://api.slack.com/reference/block-kit/composition-objects
 */
abstract class Composition implements \JsonSerializable {}