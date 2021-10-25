<?php

namespace App\Service\Url;

class UrlGenerationService
{
    const DEFAULT_PATH_LENGTH = 8;

    public function generatePath(int $length = self::DEFAULT_PATH_LENGTH): string
    {
        $charSet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle($charSet),
            0, $length);
    }
}