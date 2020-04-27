<?php
declare(strict_types=1);

namespace SIF\Components\Blocks;

use SIF\Components\Compositions\Text;
use SIF\Components\Exceptions\RangeException;

/**
 * An image
 * @package SIF\Components\Blocks
 * @see https://api.slack.com/reference/block-kit/blocks#image
 */
class Image extends Block {

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
     * @var Text|null A title
     */
    public ?Text $title;

    /**
     * @param string $url
     * @param string $alt
     * @param Text|string|null $title
     * @param string|null $id
     */
    public function __construct(string $url, string $alt, $title = null, ?string $id = null) {
        parent::__construct($id);

        if(!empty($title)) {
            if(is_string($title)) {
                $title = new Text($title, Text::PLAINTEXT);
            }
            $title->type = Text::PLAINTEXT; // force downgrade
            if(strlen($title->text) > 2000) {
                throw new \RangeException('The maximum length of an image title is 2000 characters');
            }
        }

        $this->url = $url;
        $this->alt = $alt;
        $this->title = $title;
    }

    public function jsonSerialize() {
        return parent::jsonSerialize() + [
                'type'  =>  $this->type,
                'image_url' => $this->url,
                'alt_text' => $this->alt
            ];
    }

}