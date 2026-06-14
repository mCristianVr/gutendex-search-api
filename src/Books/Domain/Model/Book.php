<?php

declare(strict_types=1);

namespace App\Books\Domain\Model;

final class Book
{

    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly array $authors,
        private readonly array $subjects
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function getSubjects(): array
    {
        return $this->subjects;
    }

}
