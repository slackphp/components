<?php
declare(strict_types=1);

namespace SIF\Components\Compositions;

use SIF\Components\Exceptions\OutOfRangeException;

/**
 * A conversation filter group
 * @package SIF\Components\Compositions
 * @see https://api.slack.com/reference/block-kit/composition-objects#filter_conversations
 */
class ConversationFilter extends Composition {

    /**
     * @var array|string[] A list of filters
     */
    public array $include = [self::FILTER_IM, self::FILTER_MPIM, self::FILTER_PRIVATE, self::FILTER_PUBLIC];

    /**
     * @var bool Should external shared channels be excluded
     */
    public bool $excludeExternalSharedChannels = false;

    /**
     * @var bool Should bot users be excluded
     */
    public bool $excludeBotUsers = false;

    public const FILTER_IM = 'im';
    public const FILTER_MPIM = 'mpim';
    public const FILTER_PRIVATE = 'private';
    public const FILTER_PUBLIC = 'public';

    public function __construct(array $include = [self::FILTER_IM, self::FILTER_MPIM, self::FILTER_PRIVATE, self::FILTER_PUBLIC], bool $excludeExternalSharedChannels = false, bool $excludeBotUsers = false) {
        if(count($include) === 0) {
            throw new OutOfRangeException('A conversation filter must have at least one filter defined');
        }
        $this->include = $include;
        $this->excludeExternalSharedChannels = $excludeExternalSharedChannels;
        $this->excludeBotUsers = $excludeBotUsers;
    }

    public function jsonSerialize() {
        return [
            'include'   =>  $this->include,
            'exclude_external_shared_channels' => $this->excludeExternalSharedChannels,
            'exclude_bot_users' =>  $this->excludeBotUsers
        ];
    }

}