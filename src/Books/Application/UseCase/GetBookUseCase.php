<?php 

declare(strict_types=1);

namespace App\Books\Application\UseCase;

use App\Books\Domain\Exception\BookNotFoundException;
use App\Books\Domain\Port\BookRepositoryPort;
use App\Books\Domain\Model\Book;

final class GetBookUseCase
{

    public function __construct(
        private readonly BookRepositoryPort $bookRepository
    ) {
    }

    public function execute(int $id): Book
    {
        $book = $this->bookRepository->findById($id);

        if ($book === null) {
            throw BookNotFoundException::withId($id);
        }

        return $book;
    }

}
