<?php
declare(strict_types=1);

namespace SIF\Components\Surfaces;

use SIF\Components\Blocks\Actions;
use SIF\Components\Blocks\Context;
use SIF\Components\Blocks\Divider;
use SIF\Components\Blocks\Image;
use SIF\Components\Blocks\Input;
use SIF\Components\Blocks\Section;
use SIF\Components\Compositions\Text;
use SIF\Components\Exceptions\ValueTooLargeException;

/**
 * A modal view
 * @package SIF\Components\Surfaces
 * @see https://api.slack.com/surfaces#modals
 */
class Modal extends View {

    protected string $type = 'modal';

    protected string $builderType = 'modal';

    /**
     * @var Text The modal title
     */
    public Text $title;

    /**
     * @var Text|null Text of the close button
     */
    public ?Text $close;

    /**
     * @var Text|null Text of the submit button
     */
    public ?Text $submit;

    /**
     * @var bool Whether to clear views in the modal on close
     */
    public bool $clearOnClose = false;

    /**
     * @var bool Whether to send a view_closed event on closing
     */
    public bool $notifyOnClose = false;

    protected array $supports = [
        Actions::class, Context::class, Divider::class, Image::class, Input::class, Section::class,
    ];

    /**
     * @param array $blocks
     * @param Text|string $title
     * @param string|null $id
     * @param Text|string|null $submit
     * @param Text|string|null $close
     * @param string|null $privateMetadata
     * @param bool $clearOnClose
     * @param bool $notifyOnClose
     * @param string|null $externalId
     * @throws ValueTooLargeException
     */
    public function __construct(array $blocks, $title, ?string $id = null, $submit = null, $close = null, ?string $privateMetadata = null, bool $clearOnClose = false, bool $notifyOnClose = false, ?string $externalId = null) {
        parent::__construct($blocks, $id, $privateMetadata, $externalId);

        if(is_string($title)) {
            $title = new Text($title, Text::PLAINTEXT);
        }
        $title->type = Text::PLAINTEXT; // force downgrade
        if(strlen($title->text) > 24) {
            throw new ValueTooLargeException('The maximum length of the title is 24 characters');
        }

        if(!empty($submit)) {
            if(is_string($submit)) {
                $submit = new Text($submit, Text::PLAINTEXT);
            }
            $submit->type = Text::PLAINTEXT; // force downgrade
            if(strlen($submit->text) > 24) {
                throw new ValueTooLargeException('The maximum length of a button text value is 24 characters');
            }
        }

        if(!empty($close)) {
            if(is_string($close)) {
                $close = new Text($close, Text::PLAINTEXT);
            }
            $close->type = Text::PLAINTEXT; // force downgrade
            if(strlen($close->text) > 24) {
                throw new ValueTooLargeException('The maximum length of a button text value is 24 characters');
            }
        }

        $this->title = $title;
        $this->submit = $submit;
        $this->close = $close;
        $this->clearOnClose = $clearOnClose;
        $this->notifyOnClose = $notifyOnClose;
    }

    public function jsonSerialize() {
        $surface = [
            'title' =>  $this->title,
            'clear_on_close'    =>  $this->clearOnClose,
            'notify_on_close'   =>  $this->notifyOnClose
        ];

        if($this->submit !== null) {
            $surface['submit']  = $this->submit;
        }

        if($this->close !== null) {
            $surface['close'] = $this->close;
        }

        return $surface + parent::jsonSerialize();
    }

}