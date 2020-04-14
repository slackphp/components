<?php
declare(strict_types=1);

namespace SIF\Components\Compositions;

use SIF\Components\Exceptions\ValueTooLargeException;

/**
 * A confirmation dialog
 * @package SIF\Components\Compositions
 * @see https://api.slack.com/reference/block-kit/composition-objects#confirm
 */
class Confirm extends Composition {

    /**
     * @var Text The title
     */
    public Text $title;

    /**
     * @var Text Text body
     */
    public Text $text;

    /**
     * @var Text Value of the confirm button
     */
    public Text $confirm;

    /**
     * @var Text Value of the deny button
     */
    public Text $deny;

    /**
     * @var string Style of the confirm button
     */
    public string $style = self::STYLE_PRIMARY;

    public const STYLE_PRIMARY = 'primary';
    public const STYLE_DANGER = 'danger';

    public function __construct($title, $text, $confirm = 'Confirm', $deny = 'Deny', string $style = self::STYLE_PRIMARY) {
        if(is_string($title)) {
            $title = new Text($title, Text::PLAINTEXT);
        }
        if(strlen($title->text) > 100) {
            throw new ValueTooLargeException('The maximum length of a confirm title value is 100 characters');
        }

        if(is_string($text)) {
            $text = new Text($text);
        }
        if(strlen($text->text) > 300) {
            throw new ValueTooLargeException('The maximum length of a confirm text value is 100 characters');
        }

        if(is_string($confirm)) {
            $confirm = new Text($confirm, Text::PLAINTEXT);
        }
        if(strlen($confirm->text) > 300) {
            throw new ValueTooLargeException('The maximum length of a confirm dialog confirm button value is 30 characters');
        }

        if(is_string($deny)) {
            $deny = new Text($deny, Text::PLAINTEXT);
        }
        if(strlen($deny->text) > 300) {
            throw new ValueTooLargeException('The maximum length of a confirm dialog deny button value is 30 characters');
        }

        $this->title = $title;
        $this->text = $text;
        $this->confirm = $confirm;
        $this->deny = $deny;
        $this->style = $style;
    }

    public function jsonSerialize() {
        return [
            'title' =>  $this->title,
            'text'  =>  $this->text,
            'confirm'   =>  $this->confirm,
            'deny'  =>  $this->deny,
            'style' =>  $this->style
        ];
    }

}