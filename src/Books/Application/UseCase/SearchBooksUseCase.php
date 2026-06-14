<?php

declare(strict_types=1);

namespace App\Books\Application\UseCase;

use App\Books\Domain\Port\BookRepositoryPort;

final class SearchBooksUseCase
{
    public function __construct(
        private readonly BookRepositoryPort $bookRepository
    ) {
    }

    /** @return array */
    public function execute(string $query): array
    {
        return $this->bookRepository->search($query);
    }
}
