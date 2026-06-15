<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\UseCase;

use App\Books\Application\UseCase\GetBookUseCase;
use App\Books\Domain\Model\Book;
use App\Books\Domain\Model\Author;
use App\Books\Domain\Port\BookRepositoryPort;
use PHPUnit\Framework\TestCase;
use App\Books\Domain\Exception\BookNotFoundException;

final class GetBookUseCaseTest extends TestCase
{
    public function testGetBook(): void
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
            ->method('findById')
            ->with(1)
            ->willReturn($book);

        $getBookUseCase = new GetBookUseCase($bookRepositoryMock);

        // Act
        $result = $getBookUseCase->execute(1);

        // Assert
        self::assertSame($book, $result);

    }

    public function testGetBookWithNonexistentId(): void
    {
        // Arrange
        $bookRepositoryMock = $this->createMock(BookRepositoryPort::class);
        $bookRepositoryMock->expects(self::once())
            ->method('findById')
            ->with(999)
            ->willReturn(null);

        $getBookUseCase = new GetBookUseCase($bookRepositoryMock);

        // Act
        $this->expectException(BookNotFoundException::class);
        $getBookUseCase->execute(999);

    }

}