<?php
declare(strict_types=1);

namespace SIF\Components\Surfaces;

use SIF\Components\Exceptions\RangeException;

/**
 * A view
 * @package SIF\Components\Surfaces
 * @see https://api.slack.com/reference/surfaces/views
 */
abstract class View extends Surface {

    /**
     * @var string|null A callback ID
     */
    public ?string $id;

    /**
     * @var string|null Private metadata sent with actions
     */
    public ?string $privateMetadata;

    /**
     * @var string|null A custom identifier
     */
    public ?string $externalId;

    public function __construct(array $blocks, ?string $id = null, ?string $privateMetadata = null, ?string $externalId = null) {
        parent::__construct($blocks);

        if(!empty($id)) {
            if(strlen($id) > 3000) {
                throw new \RangeException('The maximum length of a callback id is 255 characters');
            }
        }

        if(!empty($privateMetadata)) {
            if(strlen($privateMetadata) > 3000) {
                throw new \RangeException('The maximum length of private metadata is 3000 characters');
            }
        }

        $this->id = $id;
        $this->privateMetadata = $privateMetadata;
        $this->externalId = $externalId;
    }

    public function jsonSerialize() {
        $surface = [
            'type'  =>  $this->type
        ];
        if($this->id !== null) {
            $surface['callback_id'] = $this->id;
        }
        if($this->privateMetadata !== null) {
            $surface['private_metadata'] = $this->privateMetadata;
        }
        if($this->externalId !== null) {
            $surface['external_id'] = $this->externalId;
        }

        return $surface + parent::jsonSerialize();
    }

}