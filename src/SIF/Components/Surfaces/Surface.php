<?php
declare(strict_types=1);

namespace SIF\Components\Surfaces;

use SIF\Components\Exceptions\BlockNotSupportedInSurfaceException;

/**
 * A surface that defines how a message is shown
 * @package SIF\Components\Surfaces
 */
abstract class Surface implements \JsonSerializable {

    /**
     * @var string The type of surface or view to render
     */
    protected string $type;

    /**
     * @var string Determines the "mode" used in the block kit builder (which can be different to the type)
     */
    protected string $builderType;

    /**
     * @var array Array of blocks
     */
    public array $blocks;

    /**
     * @var array Blocks supported by this surface
     */
    protected array $supports;

    public function __construct(array $blocks) {
        $this->blocks = $blocks;

        // validate blocks supported by this surface
        foreach($blocks as $block) {
            if(!in_array(get_class($block), $this->supports, true)) {
                throw new BlockNotSupportedInSurfaceException('The block '.get_class($block).' is not supported in the '.$this->type.' surface');
            }
        }
    }

    /**
     * Generates a block kit builder URI to preview the view
     * @return string URI to Block Kit builder
     * @throws \JsonException
     */
    public function getBlockKitBuilderUri() : string {
        return 'https://api.slack.com/tools/block-kit-builder?'.http_build_query([
            'mode'  =>  $this->builderType,
            'view'    => json_encode($this, JSON_THROW_ON_ERROR, 512)
        ]);
    }

    /**
     * @return array Supported blocks
     */
    public function supports() : array {
        return $this->supports;
    }

    public function getType() : string {
        return $this->type;
    }

    public function getBuilderType() : string {
        return $this->builderType;
    }

    public function jsonSerialize() {
        return [
            'blocks'    =>  $this->blocks
        ];
    }

}