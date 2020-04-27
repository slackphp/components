<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Multiselect with static options
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#static_multi_select
 */
class MultiselectStatic extends Multiselect {

    protected string $type = 'multi_static_select';

    /**
     * @var array Array of options
     */
    public array $options;

    /**
     * @var array|null Array of option groups
     */
    public ?array $optionGroups;

    /**
     * @param array $options
     * @param $placeholder
     * @param string $id
     * @param array|null $optionGroups
     * @param Confirm|null $confirm
     * @param int|null $maxSelections
     * @throws OutOfRangeException
     * @throws \SIF\Components\Exceptions\RangeException
     */
    public function __construct(string $id, array $options, $placeholder, ?array $optionGroups = null, ?Confirm $confirm = null, ?int $maxSelections = null) {
        parent::__construct($id, $placeholder, $confirm, $maxSelections);

        if(count($options) === 0) {
            throw new OutOfRangeException('A select element must have at least one option');
        }

        // validate options
        foreach($options as $option) {
            if(!$option instanceof Option) {
                throw new InvalidOptionException('Options must be of the type Option');
            }
        }

        $this->options = $options;
        $this->optionGroups = $optionGroups;
    }

    public function jsonSerialize() {
        $block = [
            'options'   =>  $this->options
        ];

        if(!empty($this->optionGroups)) {
            $block['option_groups'] = $this->optionGroups;
        }

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

        return parent::jsonSerialize() + $block;
    }

}