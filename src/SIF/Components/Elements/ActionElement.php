<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

/**
 * An element that has additional actions available to it (for example: buttons)
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements
 */
abstract class ActionElement extends Element {

    /**
     * @var string The unique action ID for the element
     */
    public string $id;

    public function __construct(string $id) {
        $this->id = $id;
    }

    public function jsonSerialize() {
        return parent::jsonSerialize() + ['action_id' => $this->id];
    }

}