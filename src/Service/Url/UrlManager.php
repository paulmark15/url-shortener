<?php

declare(strict_types=1);

namespace App\Service\Url;

use App\Entity\Url;
use App\Service\BaseManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class UrlManager extends BaseManager
{
    private LoggerInterface $logger;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger
    ) {
        parent::__construct($em);
        $this->logger = $logger;
    }

    public function getOneByPath(string $path): ?Url
    {
        return $this->repository->findOneByPath($path);
    }

    public function addUrlVisit(Url $url): void
    {
        try {
            $this->update(
                $url->setRedirectsCount($url->getRedirectsCount() + 1)
            );
        } catch (\Exception $e) {
            // Updating redirects count is not crucial in system functionality
            // so let's just log it to ourselves and let people enjoy their links
            $this->logger->error($e);
        }
    }

    /**
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Url::class;
    }
}
