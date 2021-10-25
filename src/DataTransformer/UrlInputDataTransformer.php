<?php

namespace App\DataTransformer;

use ApiPlatform\Core\Bridge\Symfony\Validator\Exception\ValidationException;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Url;
use App\Validator\Url as UrlConstraint;
use App\Service\Url\UrlGenerationService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UrlInputDataTransformer implements DataTransformerInterface
{
    /**
     * @var UrlGenerationService
     */
    private UrlGenerationService $urlGenerationService;
    private ValidatorInterface $validator;

    public function __construct(UrlGenerationService $urlGenerationService, ValidatorInterface $validator)
    {
        $this->urlGenerationService = $urlGenerationService;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object, string $to, array $context = [])
    {
        $urlString = $object->url;
        $parsed = parse_url($urlString);
        if (!isset($parsed['scheme'])) {
            $urlString = 'http://' . ltrim($urlString, '/');
        }

        $violations = $this->validator->validate($urlString, new UrlConstraint());
        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }

        $url = new Url();
        $url->setOriginalUrl($urlString);
        $url->setPath($this->urlGenerationService->generatePath());

        return $url;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Url) {
            return false;
        }

        return Url::class === $to && null !== ($context['input']['class'] ?? null);
    }
}