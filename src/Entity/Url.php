<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\GetUrlRedirectsCount;
use App\Dto\UrlInput;
use App\Entity\Traits\TimestampableEntityTrait;
use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'openapi_context' => [
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema'  => [
                                'type' => 'object',
                                'properties' =>
                                    [
                                        'url' => ['type' => 'string'],
                                    ],
                            ],
                            'example' => [
                                'url' => 'https://google.com',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    itemOperations: [
        'get',
        'delete',
        'get_count' => [
            'method' => 'GET',
            'path' => '/urls/{id}/count',
            'controller' => GetUrlRedirectsCount::class,
            'openapi_context' => [
                'summary'     => 'Retrieves redirects count for Url.',
                'description' => 'Retrieves redirects count for Url.',
                'responses' => [
                    '200' => [
                        'description' => 'wd',
                        'content' => [
                            'application/json' => [
                                'schema'  => [
                                    'type' => 'object',
                                    'properties' =>
                                        [
                                            'count' => ['type' => 'int'],
                                        ],
                                ],
                                'example' => [
                                    'count' => 3,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    denormalizationContext: ['groups' => ['url']],
    input: UrlInput::class,
    normalizationContext: ['groups' => ['url']],
)]
class Url
{
    use TimestampableEntityTrait;

    /**
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     * @Groups({"url"})
     */
    private UuidInterface $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"url"})
     */
    private string $originalUrl;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"url"})
     */
    private string $path;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     * @Groups({"url"})
     */
    private int $redirectsCount = 0;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    public function setOriginalUrl(string $originalUrl): self
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getRedirectsCount(): int
    {
        return $this->redirectsCount;
    }

    public function setRedirectsCount(int $redirectsCount): self
    {
        $this->redirectsCount = $redirectsCount;

        return $this;
    }
}
