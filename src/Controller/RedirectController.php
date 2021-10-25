<?php

namespace App\Controller;

use App\Event\UrlVisitedEvent;
use App\Service\Url\UrlManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RedirectController extends AbstractController
{
    /**
     * @Route("/{path}", name="short_url_redirect")
     */
    public function redirectToOriginal(string $path, UrlManager $urlManager, EventDispatcherInterface $eventDispatcher): Response
    {
        $url = $urlManager->getOneByPath($path);
        if (!$url) {
            throw $this->createNotFoundException('Url does not exist');
        }
        $eventDispatcher->dispatch(new UrlVisitedEvent($url), UrlVisitedEvent::NAME);

        return parent::redirect($url->getOriginalUrl(), Response::HTTP_FOUND);
    }
}