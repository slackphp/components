<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Text;
use SIF\Components\Exceptions\OutOfRangeException;
use SIF\Components\Exceptions\RangeException;

class PlaintextInput extends ActionElement {

    protected string $type = 'plain_text_input';

    /**
     * @var Text|null Placeholder text
     */
    public ?Text $placeholder;

    /**
     * @var string|null Initial value of the field
     */
    public ?string $initialValue;

    /**
     * @var bool Field is multiline
     */
    public bool $multiline = false;

    /**
     * @var int|null Minimum length of entered text
     */
    public ?int $minLength;

    /**
     * @var int|null Maximum length of entered text
     */
    public ?int $maxLength;

    public function __construct(string $id, $placeholder = null, ?string $initialValue = null, bool $multiline = false, ?int $minLength = null, ?int $maxLength = null) {
        parent::__construct($id);

        if(is_string($placeholder)) {
            $placeholder = new Text($placeholder, Text::PLAINTEXT);
            if(strlen($placeholder->text) > 150) {
                throw new \RangeException('The maximum length of the placeholder is 150 characters');
            }
        }

        if($minLength !== null && $minLength > 3000) {
            throw new \RangeException('The maximum minlength on a text field is 3000 characters');
        }

        $this->placeholder = $placeholder;
        $this->initialValue = $initialValue;
        $this->multiline = $multiline;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    public function jsonSerialize() {
        $block = [
            'multiline' => $this->multiline
        ];

        if($this->placeholder !== null) {
            $block['placeholder'] = $this->placeholder;
        }

        if($this->initialValue !== null) {
            $block['initial_value'] = $this->initialValue;
        }

        if($this->minLength !== null) {
            $block['min_length'] = $this->minLength;
        }

        if($this->maxLength !== null) {
            $block['max_length'] = $this->maxLength;
        }

        return parent::jsonSerialize() + $block;
    }

}