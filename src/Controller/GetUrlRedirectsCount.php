<?php

namespace App\Controller;

use App\Entity\Url;
use App\Handler\UrlRedirectsCountHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetUrlRedirectsCount extends AbstractController
{
    /**
     * @var UrlRedirectsCountHandler $handler
     */
    private UrlRedirectsCountHandler $handler;

    public function __construct(UrlRedirectsCountHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Url $data): JsonResponse
    {
        return $this->handler->handle($data);
    }
}