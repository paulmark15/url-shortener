<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Url;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class UrlsTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/urls');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Url',
            '@id' => '/api/urls',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 10,
        ]);
        $this->assertCount(10, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Url::class);
    }

    public function testCreateUrl(): void
    {
        $response = static::createClient()->request('POST', '/api/urls', ['json' => [
            'url' => 'google.com',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Url',
            '@type' => 'Url',
            'originalUrl' => 'http://google.com',
        ]);
        $this->assertMatchesRegularExpression('~^/api/urls/\b[0-9a-f]{8}\b-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-\b[0-9a-f]{12}\b~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Url::class);
    }

    public function testCreateInvalidUrl(): void
    {
        static::createClient()->request('POST', '/api/urls', ['json' => [
            'url' => 'google.com<DROP DATABASE>', // not gonna happen
        ]]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testDeleteUrl(): void
    {
        $client = static::createClient();
        $iri = $this->findIriBy(Url::class, ['path' => 'uihrdife']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            $this->getContainer()->get('doctrine')->getRepository(Url::class)->findOneBy(['path' => 'uihrdife'])
        );
    }
}