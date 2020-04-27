<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\ConversationFilter;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Select with conversations list
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#conversation_select
 */
class SelectConversation extends Select {

    protected string $type = 'conversations_select';

    /**
     * @var string|null Conversation ID to preselect
     */
    public ?string $initialConversation;

    /**
     * @var ConversationFilter|null A conversation filter
     */
    public ?ConversationFilter $filter = null;

    public bool $responseUrlEnabled = false;

    /**
     * @param string $id
     * @param $placeholder
     * @param string|null $initialConversation
     * @param ConversationFilter|null $filter
     * @param Confirm|null $confirm
     * @param bool $responseUrlEnabled
     * @throws \SIF\Components\Exceptions\RangeException
     */
    public function __construct(string $id, $placeholder,  ?string $initialConversation = null, ?ConversationFilter $filter = null, ?Confirm $confirm = null, bool $responseUrlEnabled = false) {
        parent::__construct($id, $placeholder, $confirm);

        $this->initialConversation = $initialConversation;
        $this->filter = $filter;
        $this->responseUrlEnabled = $responseUrlEnabled;
    }

    public function jsonSerialize() {
        if(!empty($this->initialUsers)) {
            $block['initial_users'] = $this->initialUsers;
        }

        if($this->responseUrlEnabled) {
            $block['response_url_enabled'] = $this->responseUrlEnabled;
        }

        return parent::jsonSerialize() + $block;
    }

}