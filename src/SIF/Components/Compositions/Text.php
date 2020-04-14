<?php
declare(strict_types=1);

namespace SIF\Components\Compositions;

/**
 * A text composition object
 * @package SIF\Components\Compositions
 * @see https://api.slack.com/reference/block-kit/composition-objects#text
 */
class Text extends Composition {

    /**
     * @var string The type of text composition
     */
    public string $type = 'mrkdwn';

    /**
     * @var string The text body
     */
    public string $text;

    /**
     * @var bool Should emojis be escaped into their colon format (only used if $type is plain_text)
     */
    public bool $emoji = false;

    /**
     * @var bool Should text be left exactly as-is (without processing) (only used if $type is mrkdwn)
     */
    public bool $verbatim = false;

    public const MARKDOWN = 'mrkdwn';
    public const PLAINTEXT = 'plain_text';

    /**
     * A text composition object
     * @param string $type
     * @param string $text
     * @param bool $emoji
     * @param bool $verbatim
     */
    public function __construct(string $text, string $type = self::MARKDOWN, bool $emoji = false, bool $verbatim = false) {
        $this->type = $type;
        $this->text = $text;
        $this->emoji = $emoji;
        $this->verbatim = $verbatim;
    }

    public function jsonSerialize() {
        $payload = [
            'type'  =>  $this->type,
            'text'  =>  $this->text,
        ];
        if($this->type === self::PLAINTEXT) {
            $payload['emoji'] = $this->emoji;
        }
        if($this->type === self::MARKDOWN) {
            $payload['verbatim'] = $this->verbatim;
        }

        return $payload;
    }

}