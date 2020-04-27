<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Option;
use SIF\Components\Exceptions\InvalidOptionException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * Multiselect with user list
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#users_multi_select
 */
class MultiselectUser extends Multiselect {

    protected string $type = 'multi_users_select';

    /**
     * @var array|null User IDs to preselect
     */
    public ?array $initialUsers;

    /**
     * @param string $id
     * @param $placeholder
     * @param array|null $initialUsers
     * @param Confirm|null $confirm
     * @param int|null $maxSelections
     * @throws \SIF\Components\Exceptions\RangeException
     */
    public function __construct(string $id, $placeholder, ?array $initialUsers = null, ?Confirm $confirm = null, ?int $maxSelections = null) {
        parent::__construct($id, $placeholder, $confirm, $maxSelections);

        $this->initialUsers = $initialUsers;
    }

    public function jsonSerialize() {
        if(!empty($this->initialUsers)) {
            $block['initial_users'] = $this->initialUsers;
        }

        return parent::jsonSerialize() + $block;
    }

}