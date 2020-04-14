<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

use SIF\Components\Elements\Button;
use SIF\Components\Elements\Checkboxes;
use SIF\Components\Elements\Datepicker;
use SIF\Components\Elements\Overflow;
use SIF\Components\Elements\PlaintextInput;
use SIF\Components\Elements\RadioButtons;
use SIF\Components\Elements\SelectChannel;
use SIF\Components\Elements\SelectConversation;
use SIF\Components\Elements\SelectExternal;
use SIF\Components\Elements\SelectStatic;
use SIF\Components\Elements\SelectUser;
use SIF\Components\Exceptions\ElementNotSupportedInBlockException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * An actions block
 * @package SIF\Components\Blocks
 * @see https://api.slack.com/reference/block-kit/blocks#actions
 */
class Actions extends Block {

    protected string $type = 'actions';

    /**
     * @var array An array of elements
     */
    public array $elements = [];

    protected array $supports = [
        Button::class,
        Checkboxes::class,
        Datepicker::class,
        Overflow::class,
        PlaintextInput::class,
        RadioButtons::class,
        SelectStatic::class,
        SelectExternal::class,
        SelectUser::class,
        SelectConversation::class,
        SelectChannel::class,
    ];

    /**
     * @param array $elements
     * @param string|null $id
     * @throws OutOfRangeException
     * @throws \SIF\Components\Exceptions\ValueTooLargeException
     */
    public function __construct(array $elements, ?string $id = null) {
        parent::__construct($id);

        $count = count($elements);
        if($count === 0 || $count > 100) {
            throw new OutOfRangeException('A minimum of 1 and a maximum of 10 elements must exist in an action block');
        }

        // validate elements supported by this block
        foreach($elements as $element) {
            if(!in_array(get_class($element), $this->supports, true)) {
                throw new ElementNotSupportedInBlockException('The element '.get_class($element).' is not supported in the '.$this->type.' block');
            }
        }

        $this->elements = $elements;
    }

    public function jsonSerialize() {
        return [
            'elements'  =>  $this->elements
        ] + parent::jsonSerialize();
    }

}