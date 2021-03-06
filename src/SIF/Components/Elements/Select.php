<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Text;
use SIF\Components\Exceptions\RangeException;

/**
 * Select elements extend off this
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#select
 */
abstract class Select extends ActionElement {

    public Text $placeholder;

    public ?Confirm $confirm;

    public function __construct(string $id, $placeholder, ?Confirm $confirm = null) {
        parent::__construct($id);

        if(is_string($placeholder)) {
            $placeholder = new Text($placeholder, Text::PLAINTEXT);
        }
        if(strlen($placeholder->text) > 150) {
            throw new \RangeException('The maximum length of the placeholder is 150 characters');
        }

        $this->placeholder = $placeholder;
        $this->confirm = $confirm;
    }

    public function jsonSerialize() {
        $block = [
            'placeholder'   =>  $this->placeholder
        ];

        if($this->confirm !== null) {
            $block['confirm'] = $this->confirm;
        }

        return parent::jsonSerialize() + $block;
    }

}