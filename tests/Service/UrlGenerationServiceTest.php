<?php

namespace App\Tests\Service;

use App\Service\Url\UrlGenerationService;
use PHPUnit\Framework\TestCase;

class UrlGenerationServiceTest extends TestCase
{
    public function testDefaultPathGeneration(): void
    {
        $urlService = new UrlGenerationService();
        $path = $urlService->generatePath();

        $this->assertMatchesRegularExpression('~^[a-zA-Z0-9]*~', $path);
        $this->assertEquals($urlService::DEFAULT_PATH_LENGTH, strlen($path));
    }

    public function testCustomLengthPathGeneration(): void
    {
        $customLength = 10;
        $urlService = new UrlGenerationService();
        $path = $urlService->generatePath($customLength);

        $this->assertEquals($customLength, strlen($path));
    }
}
