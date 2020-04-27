<?php
declare(strict_types=1);

namespace SIF\Components\Compositions;

use SIF\Components\Exceptions\InvalidCompositionException;
use SIF\Components\Exceptions\OutOfRangeException;
use SIF\Components\Exceptions\RangeException;

/**
 * A group of options
 * @package SIF\Components\Compositions
 * @see https://api.slack.com/reference/block-kit/composition-objects#option_group
 */
class OptionGroup extends Composition {

    /**
     * @var Text The label of the option group
     */
    public Text $label;

    /**
     * @var array A set of option compositions
     */
    public array $options = [];

    public function __construct($label, array $options) {
        if(is_string($label)) {
            $label = new Text($label, Text::PLAINTEXT);
        }
        if(strlen($label->text) > 75) {
            throw new \RangeException('The maximum length of an option group label is 75 characters');
        }

        $count = count($options);
        if($count === 0 || $count > 100) {
            throw new OutOfRangeException('A minimum of 1 and a maximum of 100 options must exist in an options group');
        }

        foreach($options as $option) {
            if(!$option instanceof Option) {
                throw new InvalidCompositionException('One or more options provided are not Option compositions');
            }
        }

        $this->label = $label;
        $this->options = $options;
    }

    public function jsonSerialize() {
        return [
            'label' =>  $this->label,
            'options'   =>  $this->options
        ];
    }

}