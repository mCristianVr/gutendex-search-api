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

```bash
vendor/bin/phpunit
```

## API Documentation

Interactive Swagger UI available at `/api/doc` when the server is running:

```
http://localhost:8000/api/doc
```
