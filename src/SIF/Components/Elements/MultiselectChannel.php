<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Multiselect with channel list
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#channel_multi_select
 */
class MultiselectChannel extends Multiselect {

    protected string $type = 'multi_channels_select';

    /**
     * @var array|null Channel IDs to preselect
     */
    public ?array $initialChannels;

    /**
     * @param string $id
     * @param $placeholder
     * @param array|null $initialChannels
     * @param Confirm|null $confirm
     * @param int|null $maxSelections
     * @throws \SIF\Components\Exceptions\ValueTooLargeException
     */
    public function __construct(string $id, $placeholder, ?array $initialChannels = null, ?Confirm $confirm = null, ?int $maxSelections = null) {
        parent::__construct($id, $placeholder, $confirm, $maxSelections);

        $this->initialChannels = $initialChannels;
    }

    public function jsonSerialize() {
        if(!empty($this->initialChannels)) {
            $block['initial_channels'] = $this->initialChannels;
        }

        return parent::jsonSerialize() + $block;
    }

}