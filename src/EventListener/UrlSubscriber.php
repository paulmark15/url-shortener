<?php

namespace App\EventListener;

use App\Event\UrlVisitedEvent;
use App\Service\Url\UrlManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UrlSubscriber implements EventSubscriberInterface
{
    private UrlManager $urlManager;

    public function __construct(UrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            UrlVisitedEvent::NAME => [['onUrlVisit', 20]],
        ];
    }

    public function onUrlVisit(UrlVisitedEvent $event)
    {
        $this->urlManager->addUrlVisit($event->getUrl());
    }
}
