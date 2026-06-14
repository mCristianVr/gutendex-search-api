<?php

declare(strict_types=1);

namespace App\Books\Domain\Exception;

final class BookNotFoundException extends \RuntimeException
{
    public static function withId(int $id): self
    {
        return new self(sprintf('Book with ID %d not found.', $id));
    }
}
