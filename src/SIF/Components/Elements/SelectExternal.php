<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Select with external data list options
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#external_select
 */
class SelectExternal extends Select {

    protected string $type = 'external_select';

    /**
     * @var int Minimum characters before a request is made to data source
     */
    public int $minQueryLength = 3;

    /**
     * @var Option|null Preselected option
     */
    public ?Option $initialOption;

    /**
     * @param string $id
     * @param $placeholder
     * @param int $minQueryLength
     * @param Option|null $initialOption
     * @param Confirm|null $confirm
     * @throws \SIF\Components\Exceptions\ValueTooLargeException
     */
    public function __construct(string $id, $placeholder, int $minQueryLength = 3, ?Option $initialOption = null, ?Confirm $confirm = null) {
        parent::__construct($id, $placeholder, $confirm);

        $this->minQueryLength = $minQueryLength;
        $this->initialOption = $initialOption;
    }

    public function jsonSerialize() {
        $block = [
            'min_query_length'   =>  $this->minQueryLength
        ];

        if(!empty($this->initialOption)) {
            $block['initial_option'] = $this->initialOption;
        }

        return parent::jsonSerialize() + $block;
    }

}