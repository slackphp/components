<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Text;
use SIF\Components\Exceptions\RangeException;

/**
 * A Button
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#button
 */
class Button extends ActionElement {

    protected string $type = 'button';

    /**
     * @var Text|string The button text
     */
    public Text $text;

    /**
     * @var string|null A url to point to if the button is clicked
     */
    public ?string $url;

    /**
     * @var string|null The value to send in the interaction payload
     */
    public ?string $value;

    /**
     * @var string|null The button style
     */
    public ?string $style;

    /**
     * @var Confirm|null An optional confirmation dialog to show when clicked
     */
    public ?Confirm $confirm;

    public const STYLE_PRIMARY = 'primary';
    public const STYLE_DANGER = 'danger';

    /**
     * @param string|Text $text
     * @param string $id
     * @param string|null $url
     * @param string|null $value
     * @param string|null $style
     * @param Confirm|null $confirm
     * @throws \RangeException
     */
    public function __construct(string $id, $text, ?string $url = null, ?string $value = null, ?string $style = null, ?Confirm $confirm = null) {
        parent::__construct($id);

        if(is_string($text)) {
            $text = new Text($text, Text::PLAINTEXT);
        }
        if(strlen($text->text) > 75) {
            throw new \RangeException('The maximum length of a button text value is 75 characters');
        }

        if(!empty($url) && strlen($url) > 3000) {
            throw new \RangeException('The maximum length of a button url value is 3000 characters');
        }

        if(!empty($value) && strlen($value) > 2000) {
            throw new \RangeException('The maximum length of a button value is 2000 characters');
        }

        $this->text = $text;
        $this->url = $url;
        $this->value = $value;
        $this->style = $style;
        $this->confirm = $confirm;
    }

    public function jsonSerialize() {
        $block = [
            'text'  =>  $this->text
        ];
        if(!empty($this->url)) {
            $block['url'] = $this->url;
        }
        if(!empty($this->value)) {
            $block['value'] = $this->value;
        }
        if(!empty($this->style)) {
            $block['style'] = $this->style;
        }
        if(!empty($this->confirm)) {
            $block['confirm'] = $this->confirm;
        }

        return parent::jsonSerialize() + $block;
    }

}