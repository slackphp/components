<?php
declare(strict_types=1);

namespace SIF\Components\Compositions;

use SIF\Components\Exceptions\RangeException;

class Option extends Composition {

    public Text $text;

    public string $value;

    public ?Text $description;

    public ?string $url;

    /**
     * @var bool Defines if this option is selected (with elements that support initial_options)
     */
    public bool $selected = false;

    /**
     * @param Text|string $text
     * @param string $value
     * @param bool $selected
     * @param Text|string|null $description
     * @param string|null $url
     * @throws \RangeException
     */
    public function __construct($text, string $value, bool $selected = false, $description = null, ?string $url = null) {
        if(is_string($text)) {
            $text = new Text($text, Text::PLAINTEXT); // as some option groups do not support mrkdwn, default to plain_text
        }
        if(strlen($text->text) > 75) {
            throw new \RangeException('The maximum length of an option text value is 75 characters');
        }

        if(strlen($value) > 75) {
            throw new \RangeException('The maximum length of an options value is 75 characters');
        }

        if(!empty($description)) {
            if(is_string($description)) {
                $description = new Text($description, Text::PLAINTEXT);
            }
            if(strlen($description->text) > 75) {
                throw new \RangeException('The maximum length of an option description is 75 characters');
            }
        }

        $this->text = $text;
        $this->value = $value;
        $this->description = $description;
        $this->url = $url;
        $this->selected = $selected;
    }

    public function jsonSerialize() {
        $payload = [
            'text'  =>  $this->text,
            'value' =>  $this->value
        ];

        if(!empty($this->description)) {
            $payload['description'] = $this->description;
        }
        if(!empty($this->url)) {
            $payload['url'] = $this->url;
        }

        return $payload;
    }

}