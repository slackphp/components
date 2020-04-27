<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Text;
use SIF\Components\Exceptions\RangeException;

/**
 * Multiselect elements extend off this
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#multi_select
 */
abstract class Multiselect extends ActionElement {

    public Text $placeholder;

    public ?Confirm $confirm;

    public ?int $maxSelections;

    public function __construct(string $id, $placeholder, ?Confirm $confirm = null, ?int $maxSelections = null) {
        parent::__construct($id);

        if(is_string($placeholder)) {
            $placeholder = new Text($placeholder, Text::PLAINTEXT);
        }
        if(strlen($placeholder->text) > 150) {
            throw new \RangeException('The maximum length of the placeholder is 150 characters');
        }

        $this->placeholder = $placeholder;
        $this->confirm = $confirm;
        $this->maxSelections = $maxSelections;
    }

    public function jsonSerialize() {
        $block = [
            'placeholder'   =>  $this->placeholder
        ];

        if($this->confirm !== null) {
            $block['confirm'] = $this->confirm;
        }

        if($this->maxSelections !== null) {
            $block['max_selected_items'] = $this->maxSelections;
        }

        return parent::jsonSerialize() + $block;
    }

}