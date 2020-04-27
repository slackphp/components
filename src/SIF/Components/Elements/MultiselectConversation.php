<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\ConversationFilter;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Multiselect with conversations list
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#conversation_multi_select
 */
class MultiselectConversation extends Multiselect {

    protected string $type = 'multi_conversations_select';

    /**
     * @var array|null Conversation IDs to preselect
     */
    public ?array $initialConversations;

    /**
     * @var ConversationFilter|null A conversation filter
     */
    public ?ConversationFilter $filter = null;

    /**
     * @param string $id
     * @param $placeholder
     * @param array|null $initialConversations
     * @param ConversationFilter|null $filter
     * @param Confirm|null $confirm
     * @param int|null $maxSelections
     * @throws \SIF\Components\Exceptions\RangeException
     */
    public function __construct(string $id, $placeholder,  ?array $initialConversations = null, ?ConversationFilter $filter = null, ?Confirm $confirm = null, ?int $maxSelections = null) {
        parent::__construct($id, $placeholder, $confirm, $maxSelections);

        $this->initialConversations = $initialConversations;
        $this->filter = $filter;
    }

    public function jsonSerialize() {
        if(!empty($this->initialUsers)) {
            $block['initial_users'] = $this->initialUsers;
        }

        return parent::jsonSerialize() + $block;
    }

}