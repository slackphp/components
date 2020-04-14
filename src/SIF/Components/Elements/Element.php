<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

/**
 * A block element
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements
 */
abstract class Element implements \JsonSerializable {

    /**
     * @var string The type of element
     */
    protected string $type;

    public function jsonSerialize() {
        return [
            'type' => $this->type
        ];
    }

}