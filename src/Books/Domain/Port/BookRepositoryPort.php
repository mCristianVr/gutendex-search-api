<?php

declare(strict_types=1);

namespace App\Books\Domain\Port;

use App\Books\Domain\Model\Book;

interface BookRepositoryPort
{
    /** @return Book[] */
    public function search(string $query): array;

    public function findById(int $id): ?Book;

}
