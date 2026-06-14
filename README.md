# Gutendex Search API

REST API built with Symfony 8 for searching and retrieving books from the [Gutendex](https://gutendex.com) public library API.

## Architecture

Built with Hexagonal Architecture and Domain-Driven Design (DDD):

- **Domain** — pure business logic, no framework dependencies
- **Application** — use cases (SearchBooks, GetBook)
- **Infrastructure** — Gutendex HTTP adapter
- **Presentation** — REST controllers

## Endpoints

GET /api/books?search={query}  — search books by title/author
GET /api/books/{id}            — get a book by ID

## Setup

```bash
composer install
php -S localhost:8000 -t public/
