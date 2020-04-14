<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

use SIF\Components\Compositions\Text;
use SIF\Components\Elements\Checkboxes;
use SIF\Components\Elements\Datepicker;
use SIF\Components\Elements\MultiselectChannel;
use SIF\Components\Elements\MultiselectConversation;
use SIF\Components\Elements\MultiselectExternal;
use SIF\Components\Elements\MultiselectStatic;
use SIF\Components\Elements\MultiselectUser;
use SIF\Components\Elements\PlaintextInput;
use SIF\Components\Elements\RadioButtons;
use SIF\Components\Elements\SelectChannel;
use SIF\Components\Elements\SelectConversation;
use SIF\Components\Elements\SelectExternal;
use SIF\Components\Elements\SelectStatic;
use SIF\Components\Elements\SelectUser;
use SIF\Components\Exceptions\ElementNotSupportedInBlockException;
use SIF\Components\Exceptions\ValueTooLargeException;

/**
 * An input
 * @package SIF\Components\Blocks
 * @see https://api.slack.com/reference/block-kit/blocks#input
 */
class Input extends Block {

    /**
     * @var Text The label of the input field
     */
    public Text $label;

    /**
     * @var mixed A single element todo: add valid classes to type strictness
     */
    public $element;

    /**
     * @var Text|null A hint that appears under the input
     */
    public ?Text $hint;

    /**
     * @var bool Is the field optional
     */
    public bool $optional = false;

    protected array $supports = [
        Checkboxes::class,
        Datepicker::class,
        MultiselectStatic::class,
        MultiselectExternal::class,
        MultiselectUser::class,
        MultiselectConversation::class,
        MultiselectChannel::class,
        PlaintextInput::class,
        RadioButtons::class,
        SelectStatic::class,
        SelectExternal::class,
        SelectUser::class,
        SelectConversation::class,
        SelectChannel::class,
    ];

    /**
     * @param $label
     * @param $element
     * @param string|null $id
     * @param null $hint
     * @param bool $optional
     * @throws ValueTooLargeException
     */
    public function __construct($label, $element, $hint = null, bool $optional = false, ?string $id = null) {
        parent::__construct($id);

        if(is_string($label)) {
            $label = new Text($label, Text::PLAINTEXT);
        }
        if(strlen($label->text) > 2000) {
            throw new ValueTooLargeException('The maximum length of a inputs label value is 2000 characters');
        }

        // todo: check element is valid for this block

        if(!empty($hint)) {
            if(is_string($hint)) {
                $hint = new Text($hint, Text::PLAINTEXT);
            }
            if(strlen($hint->text) > 2000) {
                throw new ValueTooLargeException('The maximum length of a inputs hint value is 2000 characters');
            }
        }

        // validate element supported by this block
        if($element !== null && !in_array(get_class($element), $this->supports, true)) {
            throw new ElementNotSupportedInBlockException('The element '.get_class($element).' is not supported in the '.$this->type.' block');
        }

        $this->element = $element;
        $this->label = $label;
        $this->hint = $hint;
        $this->optional = $optional;
    }

    public function jsonSerialize() {
        $block = [
            'label' =>  $this->label,
            'element'   =>  $this->element,
            'optional'  =>  $this->optional,
        ];

        if($this->hint !== null) {
            $block['hint'] = $this->hint;
        }

        return $block + parent::jsonSerialize();
    }

}