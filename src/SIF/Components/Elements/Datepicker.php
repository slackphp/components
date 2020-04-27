<?php
declare(strict_types=1);

namespace SIF\Components\Elements;

use SIF\Components\Compositions\Confirm;
use SIF\Components\Compositions\Text;
use SIF\Components\Exceptions\RangeException;

/**
 * A datepicker
 * @package SIF\Components\Elements
 * @see https://api.slack.com/reference/block-kit/block-elements#datepicker
 */
class Datepicker extends ActionElement {

    protected string $type = 'datepicker';

    /**
     * @var Text|null Placeholder text
     */
    public ?Text $placeholder;

    /**
     * @var \DateTimeInterface|null The initial date to show when the element is displayed
     */
    public ?\DateTimeInterface $initialDate;

    /**
     * @var Confirm|null An optional confirmation dialog
     */
    public ?Confirm $confirm;

    /**
     * @param string $id
     * @param string|Text|null $placeholder
     * @param \DateTimeInterface $initialDate
     * @param Confirm|null $confirm
     * @throws \RangeException
     */
    public function __construct(string $id, $placeholder = null, ?\DateTimeInterface $initialDate = null, ?Confirm $confirm = null) {
        parent::__construct($id);

        if(!empty($placeholder)) {
            if(is_string($placeholder)) {
                $placeholder = new Text($placeholder, Text::PLAINTEXT);
            }
            if(strlen($placeholder->text) > 150) {
                throw new \RangeException('The maximum length of a datepicker placeholder value is 150 characters');
            }
        }

        if($initialDate === null) {
            $initialDate = new \DateTime('now');
        }

        $this->placeholder = $placeholder;
        $this->initialDate = $initialDate;
        $this->confirm = $confirm;
    }

    public function jsonSerialize() {
        $block = [
            'initial_date'  =>  $this->initialDate->format('Y-m-d')
        ];

        if(!empty($this->placeholder)) {
            $block['placeholder'] = $this->placeholder;
        }

        if(!empty($this->confirm)) {
            $block['confirm'] = $this->confirm;
        }

        return parent::jsonSerialize() + $block;
    }

}