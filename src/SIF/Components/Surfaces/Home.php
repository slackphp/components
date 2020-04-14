<?php
declare(strict_types=1);

namespace SIF\Components\Surfaces;

use SIF\Components\Blocks\Actions;
use SIF\Components\Blocks\Context;
use SIF\Components\Blocks\Divider;
use SIF\Components\Blocks\Image;
use SIF\Components\Blocks\Section;
use SIF\Components\Compositions\Text;

/**
 * A home tab surface
 * @package SIF\Components\Surfaces
 * @see https://api.slack.com/surfaces/tabs
 */
class Home extends View {

    protected string $type = 'home';

    protected string $builderType = 'appHome';

    protected array $supports = [
        Actions::class, Context::class, Divider::class, Image::class, Section::class,
    ];

}