<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidCompositionException;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * A group of checkboxes
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#checkboxes
 */
class Checkboxes extends ActionElement {

    protected string $type = 'checkboxes';

    /**
     * @var array A group of option compositions (or key/value pairs)
     */
    public array $options = [];

    /**
     * @var Confirm|null An optional confirmation dialog
     */
    public ?Confirm $confirm;

    public function __construct(string $id, array $options, ?Confirm $confirm = null) {
        parent::__construct($id);

        $optionList = []; // this will store a comparison array that can be used for $initialOptions
        if(count($options) === 0) {
            throw new OutOfRangeException('A checkbox element must have at least one checkbox');
        }

        // validate options
        foreach($options as $option) {
            if(!$option instanceof Option) {
                throw new InvalidOptionException('Options must be of the type Option');
            }
        }

        $this->options = $options;
        $this->confirm = $confirm;
    }

    public function jsonSerialize() {
        $block = [
            'options'   =>  $this->options
        ];

        /** @var Option $option */
        $initialOptions = [];
        foreach($this->options as $option) {
            if($option->selected) {
                $initialOptions[] = $option;
            }
        }
        if(!empty($initialOptions)) {
            $block['initial_options'] = $initialOptions;
        }

        if(!empty($this->confirm)) {
            $block['confirm'] = $this->confirm;
        }

        return parent::jsonSerialize() + $block;
    }
}