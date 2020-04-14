<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Select with user list
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#users_select
 */
class SelectUser extends Select {

    protected string $type = 'users_select';

    /**
     * @var string|null User ID to preselect
     */
    public ?array $initialUser;

    /**
     * @param string $id
     * @param $placeholder
     * @param string|null $initialUser
     * @param Confirm|null $confirm
     * @throws \SIF\Components\Exceptions\ValueTooLargeException
     */
    public function __construct(string $id, $placeholder, ?string $initialUser = null, ?Confirm $confirm = null) {
        parent::__construct($id, $placeholder, $confirm);

        $this->initialUser = $initialUser;
    }

    public function jsonSerialize() {
        if(!empty($this->initialUsers)) {
            $block['initial_user'] = $this->initialUser;
        }

        return parent::jsonSerialize() + $block;
    }

}