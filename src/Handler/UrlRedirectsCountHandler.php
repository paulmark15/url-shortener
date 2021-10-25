<?php

namespace App\Handler;

use App\Entity\Url;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UrlRedirectsCountHandler
{
    public function handle(Url $url): JsonResponse
    {
        return new JsonResponse([
            'count' => $url->getRedirectsCount()
        ], Response::HTTP_OK);
    }
}