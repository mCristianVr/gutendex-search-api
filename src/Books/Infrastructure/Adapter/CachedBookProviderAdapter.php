<?php

declare(strict_types=1);

namespace App\Books\Infrastructure\Adapter;

use App\Books\Domain\Model\Book;
use App\Books\Domain\Port\BookRepositoryPort;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class CachedBookProviderAdapter implements BookRepositoryPort
{
    public function __construct(
        private readonly BookRepositoryPort $bookRepository,
        private readonly CacheInterface $cache
    ) {
    }

    public function search(string $query): array
    {
        $key = 'search_' . md5($query);

        return $this->cache->get($key, function (ItemInterface $item) use ($query) {
            $item->expiresAfter(3600);
            return $this->bookRepository->search($query);
        });
    }

    public function findById(int $id): ?Book
    {
        $key = 'book_' . $id;

        return $this->cache->get($key, function (ItemInterface $item) use ($id) {
            $item->expiresAfter(3600);
            return $this->bookRepository->findById($id);
        });
    }


}

