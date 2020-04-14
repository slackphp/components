<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

use SIF\Components\Compositions\Text;
use SIF\Components\Elements\Button;
use SIF\Components\Elements\Checkboxes;
use SIF\Components\Elements\Datepicker;
use SIF\Components\Elements\Element;
use SIF\Components\Elements\Image;
use SIF\Components\Elements\MultiselectChannel;
use SIF\Components\Elements\MultiselectConversation;
use SIF\Components\Elements\MultiselectExternal;
use SIF\Components\Elements\MultiselectStatic;
use SIF\Components\Elements\MultiselectUser;
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
use SIF\Components\Exceptions\ValueTooLargeException;

/**
 * A section block
 * @package SIF\Components
 * @see https://api.slack.com/reference/block-kit/blocks#section
 */
class Section extends Block {

    protected string $type = 'section';

    /**
     * @var Text|null A Text composition or a string of basic text
     */
    public ?Text $text;

    /**
     * @var array A group of Text compositions
     */
    public ?array $fields = [];

    public ?Element $element;

    protected array $supports = [
        Button::class,
        Checkboxes::class,
        Datepicker::class,
        Image::class,
        MultiselectStatic::class,
        MultiselectExternal::class,
        MultiselectUser::class,
        MultiselectConversation::class,
        MultiselectChannel::class,
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
     * @param string|Text|null $text
     * @param array|null $fields
     * @param Element|null $element
     * @param string|null $id
     * @throws OutOfRangeException|ValueTooLargeException
     */
    public function __construct($text, ?array $fields = [], ?Element $element = null, ?string $id = null) {
        parent::__construct($id);

        if(!empty($text) && is_string($text)) {
            $text = new Text($text); // convert to text composition
        }
        if(strlen($text->text) > 3000) {
            throw new ValueTooLargeException('The maximum length of a section text value is 3000 characters');
        }
        if(is_array($fields)) {
            // validate that fields are acceptable
            if(count($fields) > 10) {
                throw new OutOfRangeException('A maximum of 20 fields can be attached to a section');
            }
        }

        // validate element supported by this block
        if($element !== null && !in_array(get_class($element), $this->supports, true)) {
            throw new ElementNotSupportedInBlockException('The element '.get_class($element).' is not supported in the '.$this->type.' block');
        }

        $this->text = $text;
        $this->fields = $fields;
        $this->element = $element;
    }


    public function jsonSerialize() {
        $block = parent::jsonSerialize();
        if(!empty($this->text)) {
            $block['text'] = $this->text;
        }

        if(!empty($this->fields)) {
            $block['fields'] = $this->fields;
        }

        if(!empty($this->element)) {
            $block['accessory'] = $this->element;
        }

        return $block;
    }

}