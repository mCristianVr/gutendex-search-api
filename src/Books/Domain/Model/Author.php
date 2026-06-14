<?php

declare(strict_types=1);

namespace App\Books\Domain\Model;

final class Author
{

    public function __construct(
        private readonly string $name,
        private readonly ?int $birthYear = null,
        private readonly ?int $deathYear = null
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthYear(): ?int
    {
        return $this->birthYear;
    }

    public function getDeathYear(): ?int
    {
        return $this->deathYear;
    }

}
