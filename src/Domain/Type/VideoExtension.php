<?php

declare(strict_types=1);

namespace App\Domain\Type;

enum VideoExtension: string
{
    case MP4      = 'mp4';
    case THREE_GP = '3gp';
}
