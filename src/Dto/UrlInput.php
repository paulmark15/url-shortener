<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

final class UrlInput
{
    /**
     * @var string
     * @Groups({"url"})
     */
    public string $url;
}