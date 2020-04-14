<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

/**
 * An image
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#image
 */
class Image extends Element {

    protected string $type = 'image';

    /**
     * @var string A fully qualified URL to the image
     */
    public string $url;

    /**
     * @var string Alternative plain-text summary
     */
    public string $alt;

    /**
     * @param string $url
     * @param string $alt
     */
    public function __construct(string $url, string $alt) {
        $this->url = $url;
        $this->alt = $alt;
    }

    public function jsonSerialize() {
        return parent::jsonSerialize() + [
            'type'  =>  $this->type,
            'image_url' => $this->url,
            'alt_text' => $this->alt
        ];
    }

}