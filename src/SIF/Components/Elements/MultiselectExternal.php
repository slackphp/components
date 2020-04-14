<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Multiselect with external data list options
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#external_multi_select
 */
class MultiselectExternal extends Multiselect {

    protected string $type = 'multi_external_select';

    /**
     * @var int Minimum characters before a request is made to data source
     */
    public int $minQueryLength = 3;

    /**
     * @var array|null Array of preselected options
     */
    public ?array $initialOptions;

    /**
     * @param string $id
     * @param $placeholder
     * @param int $minQueryLength
     * @param array|null $initialOptions
     * @param Confirm|null $confirm
     * @param int|null $maxSelections
     * @throws \SIF\Components\Exceptions\ValueTooLargeException
     */
    public function __construct(string $id, $placeholder, int $minQueryLength = 3, ?array $initialOptions = null, ?Confirm $confirm = null, ?int $maxSelections = null) {
        parent::__construct($id, $placeholder, $confirm, $maxSelections);

        if(!empty($initialOptions)) {
            // validate options and initialoptions
            foreach($initialOptions as $option) {
                if(!$option instanceof Option) {
                    throw new InvalidOptionException('Options must be of the type Option');
                }
            }
        }

        $this->minQueryLength = $minQueryLength;
        $this->initialOptions = $initialOptions;
    }

    public function jsonSerialize() {
        $block = [
            'min_query_length'   =>  $this->minQueryLength
        ];

        if(!empty($this->initialOptions)) {
            $block['initial_options'] = $this->initialOptions;
        }

        return parent::jsonSerialize() + $block;
    }

}