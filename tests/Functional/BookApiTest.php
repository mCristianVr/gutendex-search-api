<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class BookApiTest extends WebTestCase
{
    public function testSearchBooks(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/books?search=moby');

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');
    }

    public function testSearchBadQuery(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/books?search=a');

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseFormatSame('json');
    }

    public function testGetBookById(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/books/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');
    }
    
    public function testGetBookByIdBadId(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/books/999999');

        $this->assertResponseStatusCodeSame(404);
        $this->assertResponseFormatSame('json');
    }

}
