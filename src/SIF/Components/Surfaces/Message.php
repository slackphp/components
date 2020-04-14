<?php
declare(strict_types=1);

namespace SIF\Components\Surfaces;

use SIF\Components\Blocks\Actions;
use SIF\Components\Blocks\Context;
use SIF\Components\Blocks\Divider;
use SIF\Components\Blocks\File;
use SIF\Components\Blocks\Image;
use SIF\Components\Blocks\Section;

/**
 * A basic message surface
 * @package SIF\Components\Surfaces
 * @see https://api.slack.com/surfaces#messages
 */
class Message extends Surface {

    protected string $type = 'message';

    protected string $builderType = 'message';

    protected array $supports = [
        Actions::class, Context::class, Divider::class, File::class, Image::class, Section::class,
    ];

}