<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Select with channel list
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#channel_select
 */
class SelectChannel extends Select {

    protected string $type = 'channels_select';

    /**
     * @var string|null Channel ID to preselect
     */
    public ?string $initialChannel;

    public bool $responseUrlEnabled;

    /**
     * @param string $id
     * @param $placeholder
     * @param string|null $initialChannel
     * @param Confirm|null $confirm
     * @param bool $responseUrlEnabled
     * @throws \SIF\Components\Exceptions\RangeException
     */
    public function __construct(string $id, $placeholder, ?string $initialChannel = null, ?Confirm $confirm = null, bool $responseUrlEnabled = false) {
        parent::__construct($id, $placeholder, $confirm);

        $this->initialChannel = $initialChannel;
        $this->responseUrlEnabled = $responseUrlEnabled;
    }

    public function jsonSerialize() {
        if(!empty($this->initialChannels)) {
            $block['initial_channels'] = $this->initialChannels;
        }

        if($this->responseUrlEnabled) {
            $block['response_url_enabled'] = $this->responseUrlEnabled;
        }

        return parent::jsonSerialize() + $block;
    }

}