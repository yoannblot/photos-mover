<?php

declare(strict_types=1);

namespace App\Domain\Type;

enum ImageExtension: string
{
    case JPG  = 'jpg';
    case GIF  = 'gif';
    case PNG  = 'png';
    case JPEG = 'jpeg';
    case HEIC = 'heic';
    case HEIF = 'heif';
}
