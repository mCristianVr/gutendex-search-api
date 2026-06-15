<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase;

use App\Books\Application\UseCase\SearchBooksUseCase;
use App\Books\Domain\Model\Book;
use App\Books\Domain\Model\Author;
use App\Books\Domain\Port\BookRepositoryPort;
use PHPUnit\Framework\TestCase;

final class SearchBookUseCaseTest extends TestCase
{
    public function testSearchBooks(): void
    {
        // Arrange
        $book = new Book(
            1,
            'Test Book',
            [new Author('Test Author', 1970, null)],
            ['Fiction']
        );

        $bookRepositoryMock = $this->createMock(BookRepositoryPort::class);
        $bookRepositoryMock->expects(self::once())
            ->method('search')
            ->with('test')
            ->willReturn([$book]);

        $searchBooksUseCase = new SearchBooksUseCase($bookRepositoryMock);

        // Act
        $result = $searchBooksUseCase->execute('test');

        // Assert
        self::assertCount(1, $result);
        self::assertSame($book, $result[0]);

    }

    public function testSearchBooksWithNoResults(): void
    {
        // Arrange
        $bookRepositoryMock = $this->createMock(BookRepositoryPort::class);
        $bookRepositoryMock->expects(self::once())
            ->method('search')
            ->with('nonexistent')
            ->willReturn([]);

        $searchBooksUseCase = new SearchBooksUseCase($bookRepositoryMock);

        // Act
        $result = $searchBooksUseCase->execute('nonexistent');

        // Assert
        self::assertEmpty($result);

    }

}
