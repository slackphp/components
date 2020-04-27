<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

use SIF\Components\Compositions\Text;
use SIF\Components\Elements\Image;
use SIF\Components\Exceptions\ElementNotSupportedInBlockException;
use SIF\Components\Exceptions\OutOfRangeException;

/**
 * A context block
 * @package SIF\Components\Blocks
 * @see https://api.slack.com/reference/block-kit/blocks#context
 */
class Context extends Block {

    protected string $type = 'context';

    /**
     * @var array An array of elements
     */
    public array $elements = [];

    protected array $supports = [
        Image::class,
        Text::class, // in this case it supports a direct composition
    ];

    /**
     * @param array $elements
     * @param string|null $id
     * @throws ElementNotSupportedInBlockException
     */
    public function __construct(array $elements, ?string $id = null) {
        parent::__construct($id);

        $count = count($elements);
        if($count === 0 || $count > 10) {
            throw new \RangeException('A minimum of 1 and a maximum of 10 elements must exist in an context block');
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