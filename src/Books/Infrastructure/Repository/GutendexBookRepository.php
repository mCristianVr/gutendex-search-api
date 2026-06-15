<?php

declare(strict_types=1);

namespace App\Books\Infrastructure\Repository;

use App\Books\Domain\Model\Book;
use App\Books\Domain\Model\Author;
use App\Books\Domain\Port\BookRepositoryPort;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GutendexBookRepository implements BookRepositoryPort
{
    private const API_URL = 'https://gutendex.com/books/';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

    public function search(string $query): array
    {
        $response = $this->httpClient->request('GET', self::API_URL, [
            'query' => ['search' => $query],
        ]);

        $data = $response->toArray();

        return array_map(
            fn(array $bookData) => $this->mapToBook($bookData),
            $data['results'] ?? []
        );
    }

    public function findById(int $id): ?Book
    {
        $response = $this->httpClient->request('GET', self::API_URL . '/' . $id);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        return $this->mapToBook($response->toArray());
    }

    private function mapToBook(array $data): Book
    {
        $authors = array_map(
            fn(array $a) => new Author(
                $a['name'],
                $a['birth_year'] ?? null,
                $a['death_year'] ?? null
            ),
            $data['authors'] ?? []
        );
        
        return new Book(
            $data['id'],
            $data['title'],
            $authors,
            $data['subjects'] ?? [],
        );
    }
}
