<?php

namespace App\Event;

use App\Entity\Url;
use Symfony\Contracts\EventDispatcher\Event;

class UrlVisitedEvent extends Event
{
    public const NAME = 'url.visited';

    /**
     * @var Url
     */
    protected Url $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    public function getUrl(): Url
    {
        return $this->url;
    }
}
