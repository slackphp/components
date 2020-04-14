<?php
declare(strict_types=1);

namespace SIF\Components\Tests\Elements;

use SIF\Components\Compositions\Confirm;

trait ConfirmTrait {

    protected Confirm $confirm;

    public function setupConfirm(): void {
        $this->confirm = new Confirm('Confirm title', 'Text');
    }

}