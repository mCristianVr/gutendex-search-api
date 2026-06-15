# Gutendex Search API

REST API built with Symfony 8 for searching and retrieving books from the [Gutendex](https://gutendex.com) public library API.

## Architecture

Built with Hexagonal Architecture and Domain-Driven Design (DDD):

- **Domain** — pure business logic, no framework dependencies
- **Application** — use cases (SearchBooks, GetBook)
- **Infrastructure** — Gutendex HTTP adapter
- **Presentation** — REST controllers

## Caching

Responses are cached using Symfony's filesystem cache (via the Decorator pattern):

- Book search results: 1 hour
- Individual book details: 1 hour

The `CachedBookProviderAdapter` wraps `GutendexBookRepository` transparently — no changes needed to the domain or application layers.

## Endpoints

GET /api/books?search={query}  — search books by title/author

GET /api/books/{id}            — get a book by ID

## Setup

```bash
composer install
php -S localhost:8000 -t public/
```

## Tests
> **Note:** Behat was considered for functional testing but is not yet compatible with Symfony 8. 
> Symfony's built-in `WebTestCase` was used instead

Run unit tests:
```bash
vendor/bin/phpunit tests/Unit/
```

Run functional tests (requires internet connection to Gutendex):
```bash
vendor/bin/phpunit tests/Functional/
```

Run all tests
```bash
vendor/bin/phpunit
```

## API Documentation

Interactive Swagger UI available at `/api/doc` when the server is running:

```
http://localhost:8000/api/doc
```
