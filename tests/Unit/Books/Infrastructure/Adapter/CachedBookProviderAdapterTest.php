<?php

declare(strict_types=1);

namespace App\Tests\Unit\Books\Infrastructure\Adapter;

use App\Books\Domain\Model\Book;
use App\Books\Domain\Model\Author;
use App\Books\Domain\Port\BookRepositoryPort;
use App\Books\Infrastructure\Adapter\CachedBookProviderAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class CachedBookProviderAdapterTest extends TestCase
{
    public function testSearchReturnsCachedResults(): void
    {
        // Arrange
        $book = new Book(
            1,
            'Test Book',
            [new Author('Test Author', 1970, null)],
            ['Fiction']
        );

        $innerMock = $this->createMock(BookRepositoryPort::class);
        $innerMock->expects(self::once())
            ->method('search')
            ->with('test')
            ->willReturn([$book]);

        $itemStub = $this->createStub(ItemInterface::class);

        $cacheStub = $this->createStub(CacheInterface::class);
        $cacheStub->method('get')
            ->willReturnCallback(function (string $key, callable $callback) use ($itemStub) {
                return $callback($itemStub);
            });

        $adapter = new CachedBookProviderAdapter($innerMock, $cacheStub);

        // Act
        $result = $adapter->search('test');

        // Assert
        self::assertCount(1, $result);
        self::assertSame($book, $result[0]);
    }

    public function testFindByIdReturnsCachedResult(): void
    {
        // Arrange
        $book = new Book(
            1,
            'Test Book',
            [new Author('Test Author', 1970, null)],
            ['Fiction']
        );

        $innerMock = $this->createMock(BookRepositoryPort::class);
        $innerMock->expects(self::once())
            ->method('findById')
            ->with(1)
            ->willReturn($book);

        $itemStub = $this->createStub(ItemInterface::class);

        $cacheStub = $this->createStub(CacheInterface::class);
        $cacheStub->method('get')
            ->willReturnCallback(function (string $key, callable $callback) use ($itemStub) {
                return $callback($itemStub);
            });

        $adapter = new CachedBookProviderAdapter($innerMock, $cacheStub);

        // Act
        $result = $adapter->findById(1);

        // Assert
        self::assertSame($book, $result);
    }

}
