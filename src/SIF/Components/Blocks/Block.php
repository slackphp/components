<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

use SIF\Components\Exceptions\RangeException;

/**
 * The core 'block', containing shared properties
 * @package SIF\Components
 */
abstract class Block implements \JsonSerializable {

    /**
     * @var string|null The block ID, if one is not provided it will be automatically generated
     */
    public ?string $id;

    /**
     * @var string The type of block
     */
    protected string $type;

    /**
     * @var array Block elements supported by this block type
     */
    protected array $supports;

    public function __construct(?string $id = null) {
        if(!empty($id)) {
            if(strlen($id) > 255) {
                throw new \RangeException('A blocks ID cannot be larger than 255 characters');
            }
        }

        $this->id = $id;
    }

    public function jsonSerialize() {
        $block = [
            'type'  =>  $this->type
        ];
        if(!empty($this->id)) {
            $block['block_id'] = $this->id;
        }
        return $block;
    }

}